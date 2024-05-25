<?php
session_start();

include('../connection/connection.php');

if (isset($_POST['btnLogin'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (empty($email) || empty($pass)) {
        echo "<script>alert('Please fill up all fields.');</script>";
    } else {
        $con = connection();

        $sqlLogin = "SELECT * FROM `patient` WHERE `Email` = ?";
        $stmt = $con->prepare($sqlLogin);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($pass, $user['Password'])) {
                $_SESSION['UserLogin'] = $user['Email'];
                $_SESSION['PatientID'] = $user['PatientID'];
                $_SESSION['login_success'] = true;

                header('Location: dashboard.php');
                exit();
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }

        $stmt->close();
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        .container {
            margin-top: 20px;
            position: relative;
            width: 400px;
            height: 440px;
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

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 15px 30px;
            font-size: 20px;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .remember-forgot {
            margin-top: 20px;
            font-size: .9em;
            color: black;
            font-weight: 500;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .remember-forgot label input {
            accent-color: black;
            margin-right: 3px;
        }

        .remember-forgot a {
            color: black;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            border-bottom: 2px solid rgb(92, 92, 92);
            margin: 30px 0;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 1em;
            color: black;
            font-weight: 500;
            pointer-events: none;
            transition: .5s;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: black;
            font-weight: 600;
            padding: 0 35px 0 5px;
        }

        .input-box .icon {
            position: absolute;
            right: 8px;
            font-size: 1.2em;
            color: black;
            line-height: 57px;
        }

        .btn {
            margin-bottom: 20px;
            width: 100%;
            height: 45px;
            background: black;
            border: none;
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            color: #fff;
            font-weight: 500;
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
                    <h1 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Registration</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top: 30px;">
                        <li class="nav-item" style="margin-right: 65px;">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item" style="margin-right: 65px;">
                            <a class="nav-link" href="registration.php">Registration</a>
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
        <span class="icon-close"><ion-icon name="close-outline"></ion-icon></span>
        <div class="form-box login">
            <h2>Login</h2>
            <?php
            if (isset($_POST['btnLogin'])) {
                echo "<div class='alert alert-danger' role='alert'>Invalid email or password.</div>";
            }
            ?>
            <form action="login.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email address</label>
                </div>

                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="pass" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                </div>
                <button type="submit" name="btnLogin" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="registration.php" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm">
                        <div class="mb-3">
                            <label for="forgotEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="forgotEmail" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="retrievePassword()">Retrieve Password</button>
                    </form>
                    <div id="passwordDisplay" class="mt-3" style="display: none;">
                        <p>Your password is: <span id="retrievedPassword"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function retrievePassword() {
            var email = document.getElementById('forgotEmail').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'retrieve_password.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('passwordDisplay').style.display = 'block';
                        document.getElementById('retrievedPassword').innerText = response.password;
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email));
        }
    </script>
    
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGQvZ6uw6R9O6XNf4gZvE6w3CqbbVxrGytlP0V2T04Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
