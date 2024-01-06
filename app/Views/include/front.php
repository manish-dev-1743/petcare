<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>
        <!-- Header -->
        <div class="header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <h2 class="company-name">Adoptable Allies</h2>
                    <div class="d-flex justify-content-between icons">
                        <img src="assets/images/shopping-cart.png">
                        <a href="login.html"><img src="assets/images/profile.png"></a>
                        <img src="assets/images/notification.png">
                    </div>
                </div>
            </div>
        </div>


        <?= $this->renderSection('content'); ?>




        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="company-name">
                            <h2>Adoptable Allies</h2>
                            <p>Adoptable Allies® is a pet adoption platform, with a aim to connect potential adopters to their needy animal and providing pet supplies and responsible pet care education since 2023.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="location">
                            <h3>Contact Detail</h3>
                            <ul>
                                <li><b>Address :</b> Kathmandu,Nepal </li>
                                <li><b>Phone :</b> <a href="tel:+9779813347990">+977 981-3347990</a> </li>
                                <li>Email : <a href="mailto:devmanish1743@gmail.com">devmanish1743@gmail.com</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="social-links">
                            <h3>Social Links</h3>
                            <a href="facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                            <a href="instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a href="twitter.com" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <p>©Copyright 2023-2024. All rights reserved.</p>
                </div>
            </div>
        </footer>

        
    </body>
    <script src="/assets/js/bootstrap.min.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <?= $this->renderSection('scripts'); ?>


</html>
