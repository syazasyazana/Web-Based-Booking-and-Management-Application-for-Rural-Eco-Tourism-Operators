<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("../../../config/config.php");

// Fetch data based on report type
$type = $_POST['report_type'] ?? 'weekly';

// Default data
$reports = [
    'weekly' => [],
    'monthly' => []
];

// Weekly report query
if ($type === 'weekly') {
    $sql = "SELECT 
                WEEK(orderDate) AS week, 
                COUNT(*) AS visitors, 
                SUM(totalPrice) AS revenue, 
                AVG(rating) AS rating
            FROM payments
            LEFT JOIN reviews ON reviews.user_id = payments.id
            GROUP BY WEEK(orderDate)";
} else {
    // Monthly report query
    $sql = "SELECT 
                MONTH(orderDate) AS month, 
                COUNT(*) AS visitors, 
                SUM(totalPrice) AS revenue, 
                AVG(rating) AS rating
            FROM payments
            LEFT JOIN reviews ON reviews.user_id = payments.id
            GROUP BY MONTH(orderDate)";
}

$result = $conn->query($sql);

// Process the data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[$type][] = $row;
    }
} else {
    echo "No data available for the selected report type.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polumpung Admin Report</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/../css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            padding-top: 80px;
        }

        header {
            background-color: #4e54c8;
            color: white;
            padding: 15px 20px;
            text-align: center;
            font-size: 24px;
        }

        .dashboard, .chart-container, .table-container {
            margin: 20px auto;
            max-width: 50%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .filter-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-form label {
            font-size: 16px;
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 4px;
            background-color: #4e54c8;
            color: white;
            border: none;
        }

        .filter-form button:hover {
            background-color: #3b3f98;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .chart-container canvas {
            max-width: 50%;
            margin: 30px auto;
        }
.table-container {
    display: flex;
    justify-content: center; /* Horizontally center */
    align-items: center; /* Vertically center */
    flex-direction: column;
    margin: 20px auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

        .table-container table {
            width: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-container th, .table-container td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table-container th {
            background-color: #f4f4f9;
            color: #333;
        }

        .table-container tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-container tr:hover {
            background-color: #f1f1f1;
        }

        .table-container td {
            font-size: 14px;
            color: #555;
        }

        /* Chart Styles */
        .chart-container canvas {
            width: 100%;
            max-width: 400px;
            height: 300px;
        }
    </style>
</head>
<body>
<!-- Top navigation -->
<div class="topNav">
  <img src="<?php echo ADMIN_BASE_URL; ?>/img/icon.png" alt="Logo">
  <a href="../../../../mainpage.php">
    <i class="fa fa-sign-out" style="font-size: 12px;"></i> Logout
  </a>
</div>

<!-- Sidebar Navigation -->
<?php
  include '../../includes/sideNav.php';
?>

<div class="dashboard">
    <form method="POST" action="" class="filter-form">
        <label for="report-type">Select Report Type:</label>
        <select name="report_type" id="report-type" required>
            <option value="weekly" <?php echo $type === 'weekly' ? 'selected' : ''; ?>>Weekly</option>
            <option value="monthly" <?php echo $type === 'monthly' ? 'selected' : ''; ?>>Monthly</option>
        </select>
        <button type="submit">Generate Report</button>
    </form>
</div>

<div class="chart-container">
    <h2>Polumpung Visitors Report (<?php echo ucfirst($type); ?>)</h2>
    <canvas id="visitorsChart"></canvas>
</div>

<div class="table-container">
    <h2>Detailed <?php echo ucfirst($type); ?> Data</h2>
    <table>
        <thead>
            <tr>
                <th><?php echo $type === 'weekly' ? 'Week' : 'Month'; ?></th>
                <th>Visitors</th>
                <th>Revenue (RM)</th>
                <th>Average Rating</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports[$type] as $item): ?>
            <tr>
                <td><?php echo $item[$type === 'weekly' ? 'week' : 'month']; ?></td>
                <td><?php echo $item['visitors']; ?></td>
                <td><?php echo number_format($item['revenue'] ?? 0, 2); ?></td>
                <td><?php echo number_format($item['rating'] ?? 0, 2); ?> / 5</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    const ctx = document.getElementById('visitorsChart').getContext('2d');
    const visitorsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($reports[$type], $type === 'weekly' ? 'week' : 'month')); ?>,
            datasets: [{
                label: 'Visitors',
                data: <?php echo json_encode(array_column($reports[$type], 'visitors')); ?>,
                backgroundColor: '#4e54c8',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Dropdown functionality for the sidebar
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
</body>
</html>
