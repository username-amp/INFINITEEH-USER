<?php
session_start();
include '../connection/connection.php';

$conn = connection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rows = [];

$patientID = isset($_SESSION["PatientID"]) ? $_SESSION["PatientID"] : '';

// Fetch appointment history with date format yyyy-mm-dd
$result = $conn->query("SELECT Client_Name, Services, Dentist, Day, Time FROM appointment_history WHERE patient_PatientID = $patientID AND Day REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Convert Time to 12-hour format with am/pm
        $time = date("g:i a", strtotime($row['Time']));
        $row['Time'] = $time;
        $rows[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="records.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('servicebg-transformed.png');
            background-size: cover;
            background-position: center;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: transparent;
        }

        .navbar-brand img {
            width: 100px;
            margin-right: 5px;
        }

        .navbar-brand {
            font-size: 20px;
            color: white !important;
        }

        .offcanvas-body {
            color: white;
        }

        .nav-link {
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .containerTable {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 175px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            min-height: 500px;
        }

        h2 {
            color: #000000;
            text-align: center;
            margin-bottom: 30px;
            font-size: 50px;
        }

        .table-container {
            width: 100%;
            backdrop-filter: blur(20px);
            background: transparent; 
            color: #000000;
            padding: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: transparent;
            color: #ffffff;
        }

        th, td {
            border: 1px solid #ffffff;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333333;
        }

        tr:nth-child(even) {
            background-color: #444444;
        }

        tr:nth-child(odd) {
            background-color: #555555;
        }


        @media screen and (max-width: 768px) {
    .containerTable {
        margin-top: 100px;
        width: 90%;
    }
    
    h2 {
        font-size: 30px;
    }
    
    .table-container {
        padding: 10px;
        border-radius: 5px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 6px;
    }
}

/* Additional styling for smaller screens if needed */

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="HomePage.html">
                <img src="infiniteethbg.png" alt="Logo">
            </a>
            <!-- Navbar toggle button for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Offcanvas menu -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Navigation links -->
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="record.php">Back</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="containerTable">
        <h2>Appointment History</h2>
        <div class="table-container">
            <?php if (empty($rows)): ?>
                <p>No appointment history found.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Dentist</th>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Client_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Services']); ?></td>
                                <td><?php echo htmlspecialchars($row['Dentist']); ?></td>
                                <td><?php echo htmlspecialchars($row['Day']); ?></td>
                                <td><?php echo htmlspecialchars($row['Time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+mBBkL3pQA+zY+WqFGKCKEGZ6iAv7PLapd52/Y5pM5aG2flak99N6GVHeS5bX9" crossorigin="anonymous"></script>

    <script>
    // Function to initialize the offcanvas menu
    var offcanvasElement = document.getElementById('offcanvasNavbar');
    var offcanvas = new bootstrap.Offcanvas(offcanvasElement);

    // Function to toggle the offcanvas menu
    function toggleOffcanvas() {
        offcanvas.toggle();
    }

    // Add event listener to the navbar toggler button
    var navbarToggler = document.querySelector('.navbar-toggler');
    navbarToggler.addEventListener('click', toggleOffcanvas);
</script>
</body>

</html>
