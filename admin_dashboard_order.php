<?php
$db_hostname = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "restauran";

$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}

// Assuming you have a database connection established
$today = date('Y-m-d');
$orderCountQuery = "SELECT COUNT(*) AS order_count FROM order_details WHERE DATE(date_time) = '$today'";
$result = mysqli_query($conn, $orderCountQuery);
$row = mysqli_fetch_assoc($result);
$totalOrders = $row['order_count'];

$orderCountQuery = "SELECT COUNT(*) AS order_count FROM order_details WHERE status IS NULL and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $orderCountQuery);
$row = mysqli_fetch_assoc($result);
$pendingOrders = $row['order_count'];
$completedOrders = $totalOrders - $pendingOrders;

$revenueQuery = "SELECT SUM(item_price) AS total_revenue FROM order_details WHERE DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$totalRevenue = $row['total_revenue'];

$revenueQuery = "SELECT SUM(quantity) AS total_revenu FROM order_details WHERE item_name = 'Pizza' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PizzaRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(quantity) AS total_revenu FROM order_details WHERE item_name = 'Pasta' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PastaRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(quantity) AS total_revenu FROM order_details WHERE item_name = 'Burger' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$BurgerRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(quantity) AS total_revenu FROM order_details WHERE item_name = 'Mango Shake' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$Mango_ShakeRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(quantity) AS total_revenu FROM order_details WHERE item_name = 'French Fries' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$French_FriesRevenue = $row['total_revenu'];

$customerCountQuery = "SELECT COUNT(*) AS customer_count FROM customer WHERE DATE(date_time) = '$today'";
$result = mysqli_query($conn, $customerCountQuery);
$row = mysqli_fetch_assoc($result);
$newCustomerRegistrations = $row['customer_count'];

$reservationCountQuery = "SELECT COUNT(*) AS reservation_count FROM reservation WHERE DATE(reservation_date) = '$today'";
$result = mysqli_query($conn, $reservationCountQuery);
$row = mysqli_fetch_assoc($result);
$reservationBookings = $row['reservation_count'];

$messageCountQuery = "SELECT COUNT(*) AS message_count FROM contact_us WHERE DATE(date_time) = '$today'";
$result = mysqli_query($conn, $messageCountQuery);
$row = mysqli_fetch_assoc($result);
$totalMessagesReceived = $row['message_count'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard.css">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">Orders</h1>
            <nav class="nav">
                <ul class="nav-list">
                    <li><a href="home1.html">Home</a></li>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="#">Customers</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="home1.html">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <div class="container">
            <div class="statistics">
                <div class="statistic" style="width: 100mm; height: 100mm;">
                    <canvas id="doughnutChart" width="100" height="100"></canvas>
                    <canvas id="pieChart" width="100" height="100"  ></canvas>
                </div>
                <div class="statistic" style="width: 100mm; height: 100mm;">
                    <canvas id="doughnutChart1" width="100" height="100"></canvas>
                    <canvas id="pieChart" width="100" height="100"  ></canvas>
                </div>
                
                <div class="statistic">
                    <h3>Total Orders:</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>
                
            </div>         
        </div>
    </main>
    

    <script>
       


       


// JavaScript: Get the canvas element and create the doughnut chart
var ctx = document.getElementById('doughnutChart').getContext('2d');

var data = {
    labels: ['CompletedOrders', 'PendingOrders',],
    datasets: [{
        data: [<?php echo $completedOrders; ?>, <?php echo $pendingOrders; ?>], // Replace with your data values
        backgroundColor: ['#00cc00', '#FF0000'], // Replace with colors
        borderColor: 'transparent', // Border color
        borderWidth: 2, // Border width
    }]
};

var options = {
    responsive: true,
    cutoutPercentage: 75, // Adjust to control the "donut hole" size
};

var doughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});

var ctx = document.getElementById('doughnutChart1').getContext('2d');

var data = {
    labels: ['Burger', 'Pizza','Pasta','Mango Shake','French Fries'],
    datasets: [{
        data: [<?php echo $BurgerRevenue; ?>, <?php echo $PizzaRevenue; ?>,<?php echo $PastaRevenue; ?>,<?php echo $Mango_ShakeRevenue; ?>,<?php echo $French_FriesRevenue; ?>], // Replace with your data values
        backgroundColor: ['#00cc00', '#FF0000','#ffc45d','#1b7ced','#8b4513'], // Replace with colors
        borderColor: 'transparent', // Border color
        borderWidth: 2, // Border width
    }]
};

var options = {
    responsive: true,
    cutoutPercentage: 75, // Adjust to control the "donut hole" size
};

var doughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});

    </script>
</body>
</html>
