<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('dentistBG.jpg');
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
        form {
            margin-top: 150px;
            width: 500px;
            background-color: beige;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .container1 {
            user-select: none;
            margin-top: 12%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: 100px;
            margin-left: 100px;
        }
        .container {
            background-color: transparent;
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            margin-bottom: 10%;
        }
        .container img {
            margin-left: 2%;
            margin-right: 17%;
            max-width: 500px;
            border: 2px solid;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .paragraph-container {
            font-family: arial;
            text-align: right;
            max-width: 100%;
        }
        .h1 {
            font-size: 50px;
        }
        .row {
            border-radius: 25px;
            background-color: #D1CEC3;
            border: 2px solid;
            margin-bottom: 100px;
        }
        .col-md-4 {
            margin-top: 10px;
        }
        .homeimg {
            margin-top: 150px;
            margin-right: auto;
            text-align: center;
        }
        .homeimg img {
            max-width: 400px;
            max-height: 300px;
            border-radius: 10px;
        }
        .dentist-header {
            font-family: arial;
            margin-top: 30px;
            text-align: center;
        }
        .card {
            background-color: rgba(234, 233, 232, 0.8);
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .card-body {
            padding: 20px;
            cursor: pointer;
        }
        .card-body .details {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .card-body.show .details {
            display: block;
            animation: fadeIn 0.5s forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }
        .card-body.hide .details {
            animation: fadeOut 0.5s forwards;
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

<div class="container1">
    <div class="container">
        <img src="dentist.jpg">
        <div class="paragraph-container">
            <p class="h1">Your great smile begins</p>
            <p class="h1">with a great <b>dentist.</b></p>
            <h>(Choose your dentist below)</h>
        </div>
    </div>

    <h2 class="dentist-header">Available Dentists</h2>
    <div class="row">
        <?php
        include('../connection/connection.php');
        $con = connection();

        $sql = "SELECT * FROM dentist";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['fullname'] . '</h5>';
                echo '<div class="details">';
                echo '<p class="card-text"><strong>Email:</strong> ' . $row['email'] . '</p>';
                echo '<p class="card-text"><strong>Working Day Hours:</strong> ' . $row['workingdayhours'] . '</p>';
                echo '<p class="card-text"><strong>Service Offered:</strong> ' . $row['serviceoffered'] . '</p>';
                echo '<p class="card-text"><strong>Specialization:</strong> ' . $row['specialization'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No dentists found.</p>';
        }
        mysqli_close($con);
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card-body');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                if (card.classList.contains('show')) {
                    card.classList.remove('show');
                    card.classList.add('hide');
                    setTimeout(() => {
                        card.classList.remove('hide');
                    }, 500);
                } else {
                    card.classList.add('show');
                }
            });
        });
    });
</script>
</body>
</html>