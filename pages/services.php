<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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
        .services{
            padding: 10px;
            margin-top: 150px;
        }
        .service-item {
            margin-bottom: 30px;
            position: relative; /* Make sure the image container is positioned relative */
            overflow: hidden; /* Hide the overflow to prevent the image from sticking out */
        }
        .service-item img {
            width: 100%;
            max-width: 400px;
            cursor: pointer; /* Change cursor to pointer */
            border-radius: 20px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
            transition: transform 0.5s ease; /* Add transition effect for smoothness */
        }
        .service-item:hover img {
            transform: translateY(-10px); /* Move the image up on hover */
        }
        .service-item p {
            font-family: Arial, Helvetica, sans-serif;
            background: rgba(0, 0, 0, 0, 0.432);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            color: black;
            font-size: x-large;
            margin-top: 20px;
            height: 4em 100%; /* Four lines of text */
            text-overflow: ellipsis;
        }
        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        h2{
            font-family: Arial, Helvetica, sans-serif;
            backdrop-filter: blur(15px);
            border-radius: 15px;
            width: 230px;
            color: black;
            padding: 5px;
            margin: 20px;
        }
        h1{
            font-family: Arial, Helvetica, sans-serif;
            color: black;
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
                    <h1 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Services</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top: 30px;">
                        <li class="nav-item" style="margin-right: 65px;">
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
<div class="container services">
    <h1 class="text-center">Available Services</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Dental Implant</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Dental_implant';">
                <img src="dentalimplant.jpg" alt="Dental Implant">
                <p>
                    Dental implants are artificial tooth roots made of titanium that are surgically placed into the jawbone to support replacement teeth, providing a stable and long-lasting solution for missing teeth.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Root Canal and Filling</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Root_canal';">
                <img src="rootcanal.jpg" alt="Root Canal">
                <p>
                    Root canal therapy involves removing infected or damaged pulp from the inside of a tooth, cleaning and disinfecting the area, and then sealing it with a filling to prevent further infection and restore functionality.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Teeth Whitening</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Teeth_whitening';">
                <img src="teethwhite.jpg" alt="Teeth Whitening">
                <p>
                    Teeth whitening procedures involve the use of bleaching agents or other methods to lighten the color of teeth and remove stains, resulting in a brighter and more attractive smile.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Crowns and Bridges</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Dental_crown';">
                <img src="crowns.jpg" alt="Crowns and Bridges">
                <p>
                    Crowns are tooth-shaped caps placed over damaged or weakened teeth to restore their strength, shape, and appearance, while bridges are dental prosthetics used to replace one or more missing teeth by anchoring artificial teeth to adjacent natural teeth or implants.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Tooth Extraction</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Tooth_extraction';">
                <img src="toothex.jpg" alt="Tooth Extraction">
                <p>
                    Tooth extraction is the removal of a tooth from its socket in the jawbone, typically performed when a tooth is severely damaged, decayed, or causing problems such as overcrowding or infection.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Invisalign</h2>
            <div class="service-item" onclick="window.location.href='https://en.wikipedia.org/wiki/Invisalign';">
                <img src="invisalign.jpg" alt="Invisalign">
                <p>
                    Invisalign is a modern orthodontic treatment that utilizes clear, removable aligners to straighten teeth gradually, offering a more discreet alternative to traditional braces.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
