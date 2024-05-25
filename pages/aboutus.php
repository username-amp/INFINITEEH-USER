<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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
            flex-direction: column;
            min-height: 100vh;
            background-image: url('bgsha.jpg');
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
            margin-left: 50px;
        }

        .container {
            padding: 20px;
            flex-grow: 1;
        }

        .aboutus-title {
            display: flex;
            justify-content: center;
            padding-top: 12px;
            text-align: center;
            font-size: 60px;
            transition: opacity 2.7s ease;
            opacity: 0;
            margin-top: 150px;
        }

        .aboutus-title.show {
            opacity: 1;
        }

        .aboutus-info {
            display: flex;
            justify-content: center;
            padding: 0 2% 0 2%;
            text-align: justify;
            font-size: 25px;
            padding: 10px 10px;
            margin: 80px;
            background-color: transparent;
            border-radius: 6px;
            
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .aboutus-info:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .aboutus-footer {
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            height: 40vh;
        }

        .footer {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px;
            text-align: center;
            margin: 80px;
            color: rgb(0, 0, 0);
            background-color: transparent;
            border-radius: 6px;
           
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .footer:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .social-icons img {
            width: 50px;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            margin: -3px;
            display: inline-block;
        }

        .social-icons img {
            width: 60px;
            transition: transform 0.3s ease;
        }

        .social-icons img:hover {
            transform: scale(1.2);
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
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item" style="margin-right: 65px;">
                        <a class="nav-link" href="registration.php">Registration</a>
                    </li>
                    <li class="nav-item" style="margin-right: 65px;">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="aboutus-title">
        <section class="header">
            <h1>ABOUT US</h1>
            <p style="font-size:23px">Behind The Scenes At Beyond</p>
        </section>
    </div>

    <div class="aboutus-info">
        <section class="content">
            <h1 style="text-align:center">WHERE BEAUTIFUL SMILES ARE MADE</h1>
            <p style="font-size:20px">
                InfiniTeeth is one of the best and most innovative dental clinics in the Philippines,
                offering quality and top-notch dental experience. This is where beautiful smiles are made.
                Our mission is to provide a user-friendly, efficient, and secure online
                platform for scheduling dental appointments, enhancing patient satisfaction, maximizing
                resource utilization, and streamlining the dental care experience. Our vision is to lead the
                industry as the premier online dental appointment system, setting new standards for convenience,
                efficiency, and security while continuously innovating to meet the evolving needs of patients
                and dental clinics.
            </p>
        </section>
    </div>
    <div class="aboutus-footer">
        <footer class="footer mt-auto">
            <h1>MAKE A BOOKING WITH US TODAY!</h1>
            <p style="font-size:22px">We Offer Wide Range Dental Services</p>
            <div class="social-icons">
                Follow Us
                <a href="#"><img src="fb.png" alt="Facebook"></a>
                <a href="#"><img src="insta.png" alt="Instagram"></a>
                <a href="#"><img src="x.png" alt="X"></a>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var aboutusTitle = document.querySelector('.aboutus-title');
    aboutusTitle.classList.add('show');
});

document.addEventListener('DOMContentLoaded', function() {
    var socialIcons = document.querySelectorAll('.social-icons img');

    socialIcons.forEach(function(icon) {
        icon.addEventListener('mouseover', function() {
            icon.style.transform = 'scale(1.2)';
            icon.style.transition = 'transform 0.3s ease';
        });

        icon.addEventListener('mouseout', function() {
            icon.style.transform = 'scale(1)';
        });
    });
});
</script>
</body>
</html>
