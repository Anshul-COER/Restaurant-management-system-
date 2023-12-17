<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code
    $db_hostname = "127.0.0.1";
    $db_username = "root";
    $db_password = "";
    $db_name = "restauran";

    $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    if (!$conn) {
        echo "Connection failed: " . mysqli_connect_error();
        exit;
    }

    // Retrieve user input
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $orderData = $_POST["manualOrder"]; // Manual order input

    // Perform validation on the input data (e.g., check for empty fields, validate email, etc.)
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid or empty email address";
    }

    if (empty($phone) || !preg_match("/^\d{10}$/", $phone)) {
        $errors[] = "Invalid or empty phone number (10 digits required)";
    }

    if (empty($address)) {
        $errors[] = "Delivery address is required";
    }

    // If there are validation errors, display them and exit
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Process the order and store it in the database
    $totalPrice = 0;

    // Create an array to store order items
    $orderItems = [];

    // Split the manual order input into individual items
    $items = explode(",", $orderData);

    foreach ($items as $item) {
        // Split each item into name and quantity
        list($itemName, $quantity) = explode("*", trim($item));

        // Remove leading and trailing whitespace
        $itemName = trim($itemName);
        $quantity = intval(trim($quantity));

        if ($quantity > 0) {
            // Query the database to get the item's price
            $getItemPriceQuery = "SELECT price FROM menu_items WHERE name = '$itemName'";
            $result = mysqli_query($conn, $getItemPriceQuery);

            if ($row = mysqli_fetch_assoc($result)) {
                $itemPrice = $row["price"];
                $totalPrice += $itemPrice * $quantity;

                // Add item to the order items array
                $orderItems[] = [
                    'name' => $itemName,
                    'quantity' => $quantity,
                    'price' => $itemPrice,
                ];
            }
        }
    }

    // Insert customer information into the database
    $insertCustomerQuery = "INSERT INTO customer (username, email, phone_no, address,date_time) VALUES ('$name', '$email', '$phone', '$address',NOW())";
    if (mysqli_query($conn, $insertCustomerQuery)) {
        $customerId = mysqli_insert_id($conn); // Get the customer ID

        // Insert order details into the database
        foreach ($orderItems as $item) {
            $itemName = $item['name'];
            $itemQuantity = $item['quantity'];
            $itemPrice = $item['price']*$item['quantity'];
            

            $insertOrderDetailsQuery = "INSERT INTO order_details (customer_id, item_name, quantity, item_price, date_time) VALUES ($customerId, '$itemName', $itemQuantity, $itemPrice,NOW())";
            mysqli_query($conn, $insertOrderDetailsQuery);
        }

        // Provide a confirmation message to the user
        

        // Close the database connection
        mysqli_close($conn);

        // Redirect the user to a confirmation page or order history page
        // header("Location: order_confirmation.php"); // Uncomment this line if you have a confirmation page
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the form was not submitted, redirect the user to the order page or show an error message
    header("Location: order_online.html");
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file here -->
</head>
<body>
    <style>
                /* Reset some default styles for consistency */
        body, h1, p, ul, li {
            margin: 0;
            padding: 0;
        }

        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        /* Main content styles */
        main {
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        ul {
            list-style: none;
        }

        li {
            margin-bottom: 10px;
        }

        strong {
            font-weight: bold;
        }

        /* Footer styles */
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }

        /* Additional custom styles can be added as needed */

    </style>
    <header>
        <!-- Header content goes here -->
    </header>

    <main>
        <div class="container">
            <h1>Order Confired</h1>
            <p>Thank you for choosing our restaurant! Your reservation details are as follows:</p>
            <ul>
                <li><strong>Name:</strong><?php echo "$name"; ?></li> <!-- Replace with actual reservation data -->
                <li><strong>Email:</strong> <?php echo "$email"; ?></li>
                <li><strong>Phone No:</strong> <?php echo "$phone"; ?></li>
                <li><strong>Address:</strong> <?php echo "$address"; ?></li>
                <li><strong>Order:</strong> <?php  foreach ($orderItems as $item) {
                    $itemName = $item["name"];
                    $itemQuantity = $item["quantity"];
                    $itemPrice = $item["price"];
                    echo $itemName . " *" . $itemQuantity . "= ₹".$itemQuantity*$itemPrice."<br>";
                }?></li>
                <li><strong>Order Total:</strong> <?php echo "₹$totalPrice"; ?></li>
                
            </ul>
            <p>Thank you for choosing [Restaurant Name] for your online order! We've received your request and will start preparing your delicious meal.</p>
        </div>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
