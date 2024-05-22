<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Homepage</title>
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
    background-image: url('estitik.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
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

.clinic-info {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    margin-top: 100px;
}

.clinic-info h2 {
    color: #007bff;
    margin-bottom: 20px;
}

.clinic-info p {
    font-size: 18px;
}

.clinic-img {
    margin-top: 50px;
}

.footer {
    background-color: transparent;
    color: white;
    padding: 20px 0;
    text-align: center;
    margin-top: auto;
}

.footer img {
    width: 30px;
    height: 30px;
    margin: 0 10px;
}

.btn-lg {
    padding: 20px 30px;
    font-size: 20px;
}

.card {
    border-radius: 12px;
    overflow: hidden;
    border: none; 
}

.bg-blur {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.3); 
    padding: 10px; 
}

.card-img-top {
    border-radius: 12px;
}

.icons img {
    width: 50px;
    height: 50px;
    transition: transform 0.3s ease;
}

.icons img:hover {
    transform: scale(1.2);
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
                        <a class="nav-link" href="registration.php">Registration</a>
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="clinic-info text-center">
                <h2>Welcome to Infiniteeth Dental Clinic</h2>
                <p>Where beautiful smiles begin! We offer comprehensive dental care with a focus on patient comfort and satisfaction. Our experienced team is dedicated to providing you with personalized, high-quality dental services to help you achieve and maintain optimal oral health.</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center clinic-img">
        <div class="col-md-6">
            <div class="card bg-blur">
                <img src="logooo-removebg-preview.png" class="card-img-top" alt="Dental Clinic">
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 text-center">
            <p><a href="registration.php" class="btn btn-primary btn-lg me-3">Get started</a>
            </p>
        </div>
    </div>

    <!-- New content sections -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="clinic-info">
                <h2>Our Services</h2>
                <ul>
                    <li>Teeth Whitening</li>
                    <li>Dental Implants</li>
                    <li>Root Canal Treatment</li>
                    <li>Orthodontics</li>
                    <li>Cosmetic Dentistry</li>
                    <li>Preventive Care</li>
                </ul>
                <p>At Infiniteeth, we use the latest technology and techniques to ensure you receive the best dental care possible. Our state-of-the-art facility and highly trained staff are here to make your visit as comfortable as possible.</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="clinic-info">
                <h2>Meet Our Team</h2>
                <p>Our team of dental professionals is committed to providing excellent care. With years of experience and a passion for dentistry, our team members are dedicated to helping you achieve a healthy, beautiful smile.</p>
                <ul>
                    <li>Dr. Cram Banzal, DDS - Head Dentist</li>
                    <li>Dr. Leigh Gegrimos, DDS - Orthodontist</li>
                    <li>Dr. Lovely Gallamos, DDS - Cosmetic Dentist</li>
                    <li>Dr. Justin Salvador, DDS - Orthodontist</li>
                    <li>Dr. Leily Derramas, DDS - Cosmetic Dentist</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="clinic-info">
                <h2>Contact Us</h2>
                <p>Have any questions? Feel free to reach out to us. We're here to help you with all your dental needs.</p>
                <ul>
                    <li>Email: Infiniteethdental.com</li>
                    <li>Phone: +639636879032</li>
                    <li>Address: 123 Dental Street, Smile City</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="footer mt-auto">
    <div class="container">
        <div class="icons">
            <div class="col-md-12">
                <h5>Connect with us:</h5>
                <a href="https://web.facebook.com/InfiniteethDental"><img src="fb.png" alt="Facebook"></a>
                <a href="#"><img src="insta.png" alt="Instagram"></a>
                <a href="#"><img src="x.png" alt="X"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Contact us: InfiniteethDental.com</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
