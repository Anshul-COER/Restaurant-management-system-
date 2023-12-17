<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here (e.g., connect to MySQL)

    // Define variables to store form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    

    // Validation (You can add more validation rules as needed)
    if (empty($name) || empty($email) || empty($message) ) {
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
        date_default_timezone_set('Asia/Kolkata');
        $date_time=date("Y-m-d H:i:s");

        // SQL query to insert reservation data into a reservations table
        $sql = "INSERT INTO contact_us (username, email, message, date_time)
                VALUES ('$name', '$email', '$message',NOW())";
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
    <title>Contact Us Details</title>
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
                <li><strong>Message:</strong> <?php echo "$message"; ?></li>
                <li><strong>Date & Time:</strong> <?php echo "$date_time"; ?></li>
                
            </ul>
            <p>Thank you for contacting us! Your message has been received. Our team will review it and respond shortly</p>
        </div>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
