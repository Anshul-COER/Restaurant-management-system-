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
$orderCountQuery = "SELECT COUNT(*) AS order_count FROM order_details ";
$result = mysqli_query($conn, $orderCountQuery);
$row = mysqli_fetch_assoc($result);
$totalOrders = $row['order_count'];

$orderCountQuery = "SELECT COUNT(*) AS order_count FROM order_details WHERE status IS NULL";
$result = mysqli_query($conn, $orderCountQuery);
$row = mysqli_fetch_assoc($result);
$pendingOrders = $row['order_count'];
$completedOrders = $totalOrders - $pendingOrders;


$revenueQuery = "SELECT SUM(item_price) AS total_revenue FROM order_details WHERE DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$todayRevenue = $row['total_revenue'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenue FROM order_details ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$totalRevenue = $row['total_revenue'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Pizza' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PizzaRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Pasta' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PastaRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Burger' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$BurgerRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Mango Shake' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$Mango_ShakeRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'French Fries' and DATE(date_time) = '$today'";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$French_FriesRevenue = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Pizza' ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PizzaRevenueT = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Pasta'  ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$PastaRevenueT = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Burger'  ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$BurgerRevenueT = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'Mango Shake'  ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$Mango_ShakeRevenueT = $row['total_revenu'];

$revenueQuery = "SELECT SUM(item_price) AS total_revenu FROM order_details WHERE item_name = 'French Fries'  ";
$result = mysqli_query($conn, $revenueQuery);
$row = mysqli_fetch_assoc($result);
$French_FriesRevenueT = $row['total_revenu'];

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
            <h1 class="logo">Admin Dashboard</h1>
            <nav class="nav">
                <ul class="nav-list">
                    <li><a href="home1.html">Home</a></li>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="admin_dashboard_order.php">Orders</a></li>
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
                <div style="width: 200mm; height: 100mm;">
                    <canvas id="myChart" width="00" height="100"></canvas>
                </div>
                <div class="statistic">
                    <h3>Today Revenue:</h3>
                    <p><?php echo '₹' . $todayRevenue; ?></p>
                </div> 
                <div style="width: 200mm; height: 100mm;">
                    <canvas id="myChart1" width="00" height="100"></canvas>
                </div> 
                <div class="statistic">
                    <h3>Total Revenue:</h3>
                    <p><?php echo '₹' . $totalRevenue; ?></p>
                </div>  
                <div style="width: 200mm; height: 100mm;">
                    <canvas id="myChart" width="00" height="100"></canvas>
                </div>
            </div>
        </div>
    </main>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');

var data = {
    labels: ['Burger', 'Pizza','Pasta','Mango Shake','French Fries'], // Labels for the data points
    datasets: [{
        label: 'Revenue',
        data: [<?php echo $BurgerRevenue; ?>, <?php echo $PizzaRevenue; ?>,<?php echo $PastaRevenue; ?>,<?php echo $Mango_ShakeRevenue; ?>,<?php echo $French_FriesRevenue; ?>], // Data values for the columns
        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color for the columns
        borderColor: 'rgba(75, 192, 192, 1)', // Border color for the columns
        borderWidth: 1 // Border width for the columns
    }]
};

var options = {
    responsive: true, // Make the chart responsive
    scales: {
        x: {
            beginAtZero: true // Start the x-axis at zero
        },
        y: {
            beginAtZero: true // Start the y-axis at zero
        }
    }
};

var myChart = new Chart(ctx, {
    type: 'bar', // Specify the chart type as 'bar' for a column chart
    data: data,
    options: options
});

var ctx = document.getElementById('myChart1').getContext('2d');

var data = {
    labels: ['Burger', 'Pizza','Pasta','Mango Shake','French Fries'], // Labels for the data points
    datasets: [{
        label: 'Revenue',
        data: [<?php echo $BurgerRevenueT; ?>, <?php echo $PizzaRevenueT; ?>,<?php echo $PastaRevenueT; ?>,<?php echo $Mango_ShakeRevenueT; ?>,<?php echo $French_FriesRevenueT; ?>], // Data values for the columns
        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color for the columns
        borderColor: 'rgba(75, 192, 192, 1)', // Border color for the columns
        borderWidth: 1 // Border width for the columns
    }]
};

var options = {
    responsive: true, // Make the chart responsive
    scales: {
        x: {
            beginAtZero: true // Start the x-axis at zero
        },
        y: {
            beginAtZero: true // Start the y-axis at zero
        }
    }
};

var myChart = new Chart(ctx, {
    type: 'bar', // Specify the chart type as 'bar' for a column chart
    data: data,
    options: options
});


</script>
</body>
</html>
