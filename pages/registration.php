<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function connection() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "infiniteeth";
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function register() {
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash the password
    $fullname = $_POST['fullname'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    
    if(empty($email) || empty($_POST['pass']) || empty($fullname) || empty($sex) || empty($age) || empty($address) || empty($contact)) {
        echo "<script>alert('Please fill up all fields.');</script>";
    } else {
        $conn = connection();
        
        $stmt = $conn->prepare("INSERT INTO patient (email, Password, `Full Name`, sex, age, address, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $email, $password, $fullname, $sex, $age, $address, $contact);
        
        if ($stmt->execute()) {
            header("Location: login.php"); // Redirect to login page on successful registration
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    register();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        .container {
            position: relative;
            margin-top: 150px;
            width: 500px;
            height: 100%;
            background: transparent;
            border: 2px solid lightgrey;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px black;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: height .2s ease;
        }
        .container h2{
            margin-top: 35px;
        }
        .form-control{
            width: 450px;
        }
        
        /* Updated styles */
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
        .navbar-toggler {
            color: white !important;
        }
        .nav-item{
            margin-right: 75px;
        }
        .btns {
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
        }

        .btns .btn {
            width: 48%;
            transition: background-color 0.3s, color 0.3s;
        }

        .btns .btn.btn-primary {
            background-color: black;
            border-color: black;
        }

        .btns .btn:hover {
            background-color: transparent;
            color: black;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logooo-removebg-preview.png" alt="Logo" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bg-white"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-black" tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                <div class="offcanvas-header">
                    <h1 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Registration</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top: 30px;">
                        <li class="nav-item" style="margin-right: 65px;">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item" style="margin-right: 65px;">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item" style="margin-right: 65px;">
                            <a class="nav-link" href="aboutus.php">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <form action="registration.php" method="post" onsubmit="return validateForm()" class="needs-validation" novalidate>
            <h2>Registration</h2>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">See</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputFullName" class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" id="exampleInputFullName" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputSex" class="form-label">Sex</label>
                <select class="form-select" name="sex" id="exampleInputSex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputAge" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" id="exampleInputAge">
            </div>
            <div class="mb-3">
                <label for="exampleInputAddress" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" id="exampleInputAddress">
            </div>
            <div class="mb-3">
                <label for="exampleInputContact" class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" id="exampleInputContact">
            </div>
            <div class="btns">
                <button type="submit" name="btnRegister" class="btn btn-primary">Register</button>
                <a href="login.php" class="btn btn-danger">Login</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function validateForm() {
            var email = document.getElementById("exampleInputEmail1").value;
            var pass = document.getElementById("exampleInputPassword1").value;
            var fullname = document.getElementById("exampleInputFullName").value;

            if (email === "" || pass === "" || fullname === "") {
                alert("Please fill in all the fields");
                return false;
            }
            return true;
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("exampleInputPassword1");
            var button = document.querySelector('#exampleInputPassword1 + .input-group > .btn');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                button.textContent = "Unsee";
            } else {
                passwordInput.type = "password";
                button.textContent = "See";
            }
        }
    </script>

</body>

</html>
