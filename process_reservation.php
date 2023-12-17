<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here (e.g., connect to MySQL)

    // Define variables to store form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $partySize = $_POST["party_size"];
    $specialRequests = $_POST["special_requests"];

    // Validation (You can add more validation rules as needed)
    if (empty($name) || empty($email) || empty($date) || empty($time) || empty($partySize)) {
        // Handle validation errors (e.g., return an error message)
        echo "Please fill in all required fields.";
    } else {
        // All required fields are filled; proceed with reservation processing

        // Insert reservation data into your database (example code)
        // Replace the placeholders with your actual database connection code
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "restauran";

        // Create a database connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Check connection
        if(!$conn){
            echo "Connection failed: ".mysqli_connect_error();
            exit;
        
        }

        // SQL query to insert reservation data into a reservations table
        $sql = "INSERT INTO reservation (username, email, phone_no, date, time1, party_size, special_requests,reservation_date)
                VALUES ('$name', '$email', '$phone', '$date', '$time', '$partySize', '$specialRequests',NOW())";
            $result = mysqli_query($conn,$sql);
            if(!$result){
                echo "Error:" .mysqli_error ($conn);
                exit;
            }
                        
            

            mysqli_close($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
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
            <h1>Reservation Confirmation</h1>
            <p>Thank you for choosing our restaurant! Your reservation details are as follows:</p>
            <ul>
                <li><strong>Name:</strong><?php echo "$name"; ?></li> <!-- Replace with actual reservation data -->
                <li><strong>Email:</strong> <?php echo "$email"; ?></li>
                <li><strong>Date:</strong> <?php echo "$date"; ?></li>
                <li><strong>Time:</strong> <?php echo "$time"; ?></li>
                <li><strong>Party Size:</strong> <?php echo "$partySize"; ?></li>
                <li><strong>Special Requests:</strong> <?php echo "$specialRequests"; ?></li>
            </ul>
            <p>We look forward to serving you on the specified date and time. If you have any questions or need to make changes to your reservation, please contact us.</p>
        </div>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
