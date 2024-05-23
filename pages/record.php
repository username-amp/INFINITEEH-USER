<?php
session_start();
include '../connection/connection.php';

$conn = connection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rows = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare SQL statement for inserting new appointments
    $stmt = $conn->prepare("INSERT INTO pendingappointments (patient_PatientID, Client_Name, Services, Dentist, Day, Time, Status, Message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssss', $patientID, $Client_Name, $Services, $Dentist, $Day, $Time, $Status, $Message);

    // Get appointment details from POST data
    $Time = isset($_POST["Time"]) ? $_POST["Time"] : '';
    $Time = date("h:i A", strtotime($Time));

    $patientID = isset($_SESSION["PatientID"]) ? $_SESSION["PatientID"] : '';
    $Client_Name = isset($_POST["Client_Name"]) ? $_POST["Client_Name"] : '';
    $Services = isset($_POST["services"]) ? $_POST["services"] : '';
    $Dentist = isset($_POST["dentist"]) ? $_POST["dentist"] : '';
    $Day = isset($_POST["Day"]) ? $_POST["Day"] : '';
    $Status = "Pending";
    $Message = isset($_POST["message"]) ? $_POST["message"] : '';

    // Execute SQL statement to insert new appointment
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['cancel'])) {
    $cancelID = $_GET['cancel'];
    $Message = isset($_GET["message"]) ? $_GET["message"] : '';

    // Fetch the details of the appointment being cancelled from pendingappointments
    $fetchStmt = $conn->prepare("SELECT patient_PatientID, Client_Name, Services, Dentist, Day, Time FROM pendingappointments WHERE PendingID = ?");
    $fetchStmt->bind_param("i", $cancelID);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    $appointmentDetails = $result->fetch_assoc();
    $fetchStmt->close();

    if ($appointmentDetails) {
        $patientID = $appointmentDetails['patient_PatientID'];
        $Client_Name = $appointmentDetails['Client_Name'];
        $Services = $appointmentDetails['Services'];
        $Dentist = $appointmentDetails['Dentist'];
        $Day = $appointmentDetails['Day']; // Keep as string

        // Convert the date format to month/day/year
        $Day = date("m/d/Y", strtotime($Day));

        $Time = $appointmentDetails['Time'];

        // Update the pendingappointments table to mark the appointment as cancelled
        $updateStmt = $conn->prepare("UPDATE pendingappointments SET Status = 'Cancelled', Message = ? WHERE PendingID = ?");
        $updateStmt->bind_param("si", $Message, $cancelID);

       if ($updateStmt->execute()) {
    // Show success message using alert
    echo "<script>alert('Appointment cancelled successfully');</script>";

    // Insert the cancelled appointment details into the appointment_history table
    $historyStmt = $conn->prepare("INSERT INTO appointment_history (patient_PatientID, Client_Name, Services, Dentist, Day, Time, Status, Message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $historyStmt->bind_param("isssssss", $patientID, $Client_Name, $Services, $Dentist, $Day, $Time, $Status, $Message);
    $Status = "Cancelled";
    if ($historyStmt->execute()) {
        // No need to display any message here
    } else {
        echo "Error in history record creation: " . $historyStmt->error;
    }
    $historyStmt->close();
} else {
    echo "Error updating record: " . $conn->error;
}
$updateStmt->close();

    }
}

if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

$patientID = isset($_SESSION["PatientID"]) ? $_SESSION["PatientID"] : '';
$result = $conn->query("SELECT PendingID, Client_Name, Services, Dentist, Day, Time, Status, Message FROM pendingappointments WHERE patient_PatientID = $patientID");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
    <title>Appointment Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="records.css" rel="stylesheet">
    <style>
        .label {
            font-weight: bold;
        }
        
        .row {
            width: 100%;
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
        .nav-link{
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

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            backdrop-filter: blur(20px);
            background: transparent; 
            color: #000000;
            text-align: left;
            padding: 20px;
            min-width: 300px;
            max-width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            width: 80%;
        }

        .card-body {
            flex-grow: 1; 
        }

        .card.pending {
            background-color: #2e2b2b3b;
        }

        .card.cancelled {
            background-color: #0d0b0b7f;
            color: white;
        }

        .card.cancelled .card-title {
            border-bottom: 1px solid white; 
        }

        .card.pending .card-title {
            border-bottom: 1px solid black; 
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 22px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid black;
        }

        .card-body .card-text {
            margin: 5px 0;
            flex-grow: 1;
        }

        .card .form-label {
            margin-top: 10px;
        }

        .card .btn-danger {
            background-color: #e74c3c;
            border: none;
            margin-top: auto;
        }

        .card .btn-danger:hover {
            background-color: #c0392b;
        }

        .separator {
            border-bottom: 1px solid #ddd;
            margin: 10px 0;
        }

        .card-expanded {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card .form-label {
            margin-top: 10px;
        }

        .status-image {
            width: 100px;
            vertical-align: middle;
        }

        .card.rejected {
            backdrop-filter: blur(20px);
            background: transparent; 
            color: #000000;
            
        }

        .card.rejected .card-title {
            border-bottom: 1px solid #721c24;
        }

        .rejected-message {
            background-color: white;
            color: black;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #fff;
        }

    </style>
</head>
<body>

<a href="history.php" class="btn btn-primary btn-floating" style="position: fixed; top: 190px; right: 50px; z-index: 1000; background-color:#000000; color:#fff; border-color:#000000;">View History</a>
    
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
                <h1 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Infiniteeth</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top: 30px;">
                    <li class="nav-item" style="margin-right: 65px;">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item" style="margin-right: 65px;">
                        <a class="nav-link" href="appointment.php?logout=true">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="containerTable">
    <h2>Appointment Details</h2>
    <div class="row justify-content-center g-4">
    <?php foreach ($rows as $index => $row): ?>
    <div class="col-md-6 col-lg-4 d-flex">
        <div class="card h-100 <?php echo ($row['Status'] == 'Cancelled') ? 'cancelled' : (($row['Status'] == 'Rejected') ? 'rejected' : 'pending'); ?>">
            <div class="card-body">
                <h5 class="card-title">Appointment ID: <?php echo $row['PendingID']; ?></h5>
                <p class="card-text"><span class="label">Fullname:</span> <?php echo $row['Client_Name']; ?></p>
                <p class="card-text"><span class="label">Services:</span> <?php echo $row['Services']; ?></p>
                <p class="card-text"><span class="label">Day:</span> <?php echo $row['Day']; ?></p>
                <p class="card-text"><span class="label">Time:</span> <?php echo date("h:i A", strtotime($row['Time'])); ?></p>
                <p class="card-text"><span class="label">Status:</span>
                    <?php if ($row['Status'] == 'Pending'): ?>
                        <img src="pendng.png" alt="Pending" class="status-image">
                    <?php elseif ($row['Status'] == 'Approved'): ?>
                        <img src="approve.png" alt="Approved" class="status-image">
                    <?php elseif ($row['Status'] == 'Rejected'): ?>
                        <img src="rejcted.png" alt="Rejected" class="status-image">
                        <p class="rejected-message">Message: <?php echo $row['Message']; ?></p>
                    <?php elseif ($row['Status'] == 'Cancelled'): ?>
                        <span class="label cancelled">Cancelled</span>
                    <?php endif; ?>
                </p>
                <?php if ($row['Status'] == 'Pending'): ?>
                    <div class="mb-3">
                        <label for="message_<?php echo $row['PendingID']; ?>" class="form-label label">Message:</label>
                        <textarea class="form-control" id="message_<?php echo $row['PendingID']; ?>" name="message_<?php echo $row['PendingID']; ?>" rows="3"></textarea>
                    </div>
                    <button onclick="cancelAppointment(<?php echo $row['PendingID']; ?>)" class="btn btn-danger">Cancel Appointment</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('card-expanded');
            });
        });
    });

    function cancelAppointment(appointmentID) {
        var message = document.getElementById("message_" + appointmentID).value;
        if (message.trim() === "") {
            alert("Please leave a message before canceling the appointment.");
            return;
        }
        var confirmation = confirm("Are you sure you want to cancel this appointment?");
        if (confirmation) {
            window.location.href = "?cancel=" + appointmentID + "&message=" + encodeURIComponent(message);
        }
    }
</script>
</body>
</html>
