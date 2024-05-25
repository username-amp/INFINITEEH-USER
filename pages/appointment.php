<?php
session_start();
include '../connection/connection.php';

$conn = connection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rows = [];

$alertMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO pendingappointments (patient_PatientID, Client_Name, Services, Dentist, Day, Time, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('issssss', $patientID, $Client_Name, $Services, $Dentist, $Day, $Time, $Status);

        $Time = isset($_POST["Time"]) ? $_POST["Time"] : '';
        $timeObj = DateTime::createFromFormat('h:i A', $Time);
        if (!$timeObj) {
            $timeObj = DateTime::createFromFormat('H:i', $Time);
        }
        if (!$timeObj) {
            echo "Invalid time format";
            exit;
        }
        $Time = $timeObj->format('H:i');

        $patientID = isset($_SESSION["PatientID"]) ? $_SESSION["PatientID"] : '';
        $Client_Name = isset($_POST["Client_Name"]) ? $_POST["Client_Name"] : '';
        $Services = isset($_POST["services"]) ? $_POST["services"] : '';
        $Dentist = isset($_POST["dentist"]) ? $_POST["dentist"] : '';
        $Day = isset($_POST["Day"]) ? $_POST["Day"] : '';
        $Status = "Pending";

        if ($stmt->execute()) {
            $alertMessage = "New record created successfully";

            // Insert into appointment_history table
            $Message = ""; // You need to define what message you want to insert here
            $historyStmt = $conn->prepare("INSERT INTO appointment_history (patient_PatientID, Client_Name, Services, Dentist, Day, Time, Status, Message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($historyStmt) {
                $historyStmt->bind_param("isssssss", $patientID, $Client_Name, $Services, $Dentist, $Day, $Time, $Status, $Message);
                if ($historyStmt->execute()) {
                    $alertMessage .= " and history record created successfully";
                } else {
                    $alertMessage = "Error in history record creation: " . $historyStmt->error;
                }
                $historyStmt->close();
            } else {
                $alertMessage = "Error: " . $conn->error;
            }
        } else {
            $alertMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $alertMessage = "Error: " . $conn->error;
    }
}

if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit;
}

$patientID = isset($_SESSION["PatientID"]) ? $_SESSION["PatientID"] : '';
$result = $conn->query("SELECT PendingID, Client_Name, Services, Dentist, Day, Time, Status FROM pendingappointments WHERE patient_PatientID = $patientID");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

$dentistResult = $conn->query("SELECT fullname FROM dentist");
$dentists = [];
if ($dentistResult && $dentistResult->num_rows > 0) {
    while ($dentistRow = $dentistResult->fetch_assoc()) {
        $dentists[] = $dentistRow['fullname'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      /* Body and navbar styles */
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: url('servicebg-transformed.png');
    background-size: cover;
    background-position: center;
    margin: 0;
}

.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
  
}

.navbar-brand img {
    width: 100px;
    margin-right: 5px;
}

.navbar-brand {
    font-size: 20px;
    color: white !important;
}

/* Offcanvas menu body */
.offcanvas-body {
    color: white;
}

/* Container box styles */
.container-box {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    margin: 20px auto;
    position: relative;
    border: 1px solid #ddd;
    width: 100%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

/* Form label styles */
.form-label {
    color: black;
    font-weight: bold;
    margin-bottom: 5px;
}

/* Form control styles */
.form-control {
    border-radius: 5px;
}

/* Primary button styles */
.btn-primary {
    border-radius: 5px;
    background-color: #007bff; /* Blue color */
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3; /* Darker blue on hover */
    border-color: #0056b3;
}

/* Navigation link styles */
.nav-link {
    color: white;
    font-weight: bold;
    font-size: 20px;
}

/* Open container styles */
.opencontainer {
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.8);
    color: #000000;
    padding: 20px;
    margin-top: 50px;
    width: 80%;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Service and describing content styles */
.service-content,
.describing-content {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

/* Image above content styles */
.image-above-content {
    width: 100%;
    height: auto;
    margin-bottom: 20px;
}

.service-content img {
    max-width: 100%;
    height: auto;
}

.describing-content img{
    max-width: 100%;
    height: auto;
    margin-top: 40px;
}

/* Media queries for responsiveness */
@media screen and (max-width: 768px) {
    .opencontainer {
        width: 90%;
        padding: 10px;
    }

    .service-content,
    .describing-content {
        width: 100%;
        margin-bottom: 20px;
        padding: 10px;
        box-shadow: none;
        background-color: #ffffff;
        border-radius: 10px;
    }

    .image-above-content {
        margin-bottom: 20px;
        width: 100%;
    }

    .service-content img {
        max-width: 100%;
        height: auto;
    }
}
/* Creative design for larger screens */
@media screen and (min-width: 769px) {
    .opencontainer {
        backdrop-filter: blur(20px);
            background: transparent; 
            color: #000000;
        display: flex;
        justify-content: space-between;
        padding: 40px;
        width: 90%;
        position: relative;
    }

    .image-above-content {
        width: calc(40% - 10px); /* Adjust the width as needed */
        height: auto;
        border-radius: 10px;
        position:static;
        left: 0;
        z-index: 1;
        margin-right: 0; /* Reduce the right margin to decrease spacing */
    }

    #appointmentForm {
        width: calc(50% - 10px); /* Adjust the width as needed */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        position: relative;
        z-index: 1;
        margin-bottom: 20px; /* Add margin to separate the sections */
    }

    .describing-content,
    .service-content {
        width: calc(50% - 10px); /* Adjust the width as needed */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        position: relative;
        z-index: 1;
        margin-bottom: 20px; /* Add margin to separate the sections */
    }

    .describing-content:before,
    .service-content:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, #007bff, transparent);
        z-index: -1;
        border-radius: 10px;
        transition: opacity 0.3s ease;
    }

    .describing-content:hover:before,
    .service-content:hover:before {
        opacity: 0.7;
    }

    .service-content img {
        max-width: 100%;
        height: 50%;
        border-radius: 10px;
        margin-top: 50px;
    }

    .service-content h1,
    .describing-content h1 {
        margin-bottom: 20px;
        font-size: 24px;
    }

    .service-content p,
    .describing-content p {
        margin-bottom: 20px;
        font-size: 18px;
    }

    .btn-primary {
        border-radius: 5px;
        background-color: #007bff;
        border-color: #007bff;
        font-size: 18px;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
}

#appointmentForm h1 {
text-align: center;
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

    <div class="opencontainer">
        <img src="tet.jpg" alt="Your Image" class="image-above-content">

        

        <form method="post" action="" id="appointmentForm">
            <h1>BOOK AN APPOINMENT</h1>
            <div class="container-box">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="Client_Name" name="Client_Name" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="dentist" class="form-label">Dentist</label>
                    <select class="form-select" id="dentist" aria-label="Select Dentist" name="dentist" onchange="fetchServices(this.value)">
                        <option selected disabled>Select Dentist</option>
                        <?php foreach ($dentists as $dentist): ?>
                            <option value="<?= htmlspecialchars($dentist) ?>"><?= htmlspecialchars($dentist) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="services" class="form-label">Services</label>
                    <select class="form-select" id="services" aria-label="Select Services" name="services">
                        <option selected disabled>Select Services</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="inputDate" class="form-label">Day</label>
                        <input type="date" name="Day" class="form-control" id="Day" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inputTime" class="form-label">Time</label>
                        <input type="time" name="Time" class="form-control" id="Time" required>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Appoint</button>
            </div>
        </form>

        <div class="describing-content">
            <h1>Trustworthy Dental Services</h1>
            <p>Our dedicated team is committed to providing top-quality dental care in a warm, welcoming atmosphere.</p>
            <a href="dentist.php" class="btn btn-primary">Click Me</a>
            <img src="serbisyo.png" alt="Services Image">

        </div>

        <div class="service-content">
            <h1>Provide Genuine Dental Care</h1>
            <p>We offer a wide range of dental services to meet your needs.</p>
            <a href="services.php" class="btn btn-primary">Learn More</a>
            <img src="serbisis.png" alt="Services Image">
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to appoint this schedule?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAppointment()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function fetchServices(dentist) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_services.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const services = JSON.parse(this.responseText);
                    let servicesDropdown = document.getElementById('services');
                    servicesDropdown.innerHTML = '<option selected disabled>Select Services</option>';
                    services.forEach(service => {
                        let option = document.createElement('option');
                        option.value = service;
                        option.text = service;
                        servicesDropdown.add(option);
                    });
                }
            };
            xhr.send('dentist=' + encodeURIComponent(dentist));
        }

        function confirmAppointment() {
            alert("Schedule for your appointment has been confirmed!");
            document.getElementById("appointmentForm").submit();
        }

        <?php if (!empty($alertMessage)): ?>
            alert("<?php echo $alertMessage; ?>");
        <?php endif; ?>
    </script>
</body>
</html>

