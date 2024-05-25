<?php
session_start();

if (!isset($_SESSION['UserLogin'])) {
    header('Location: appointment.php');
    exit();
}

if (isset($_SESSION['PatientID'])) {
    $patientID = $_SESSION['PatientID'];
}

if (isset($_GET['logout'])) {
    $_SESSION = array();

    session_destroy();

    header("Location: login.php");
    exit();
}

$_SESSION['email'] = $_SESSION['UserLogin'];

// Database connection
$host = '127.0.0.1';
$db = 'infiniteeth';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT * FROM pendingappointments WHERE patient_PatientID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$patientID]);
$appointments = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Inbox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

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

        .navbar-toggler {
            color: white !important;
        }

        .nav-item {
            margin-right: 50px;
        }

        .container {
            margin-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        .card {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        .card h2 {
            margin-bottom: 15px;
        }

        .card p {
            margin-bottom: 20px;
        }

        .card a.btn {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .card a.btn:hover {
            background-color: #0056b3;
        }

        .inbox-container {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .inbox-header {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .inbox-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .inbox-item:last-child {
            border-bottom: none;
        }

        .inbox-item .sender {
            font-weight: bold;
        }

        .inbox-item .message {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="infiniteethbg.png" alt="Logo" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bg-white"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-black" tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                <div class="offcanvas-header">
                    <h1 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dashboard</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top: 30px;">
                       
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item logout-btn">
                            <a class="nav-link" href="dashboard.php?logout=true">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="inbox-container">
            <div class="inbox-header">
                Inbox
            </div>
            <?php foreach ($appointments as $appointment): ?>
                <div class="inbox-item">
                    <div class="sender"><?php echo htmlspecialchars($appointment['Dentist']); ?></div>
                    <div class="message">
                        <?php 
                      
                        $time = date("g:i A", strtotime($appointment['TIme']));
                        echo "Your appointment for " . htmlspecialchars($appointment['Services']) . " with " . htmlspecialchars($appointment['Dentist']) . " is scheduled on " . htmlspecialchars($appointment['Day']) . " at " . $time . ". Status: " . htmlspecialchars($appointment['Status']) . ".";
                        if (!empty($appointment['Message'])) {
                            echo " Message: " . htmlspecialchars($appointment['Message']);
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
