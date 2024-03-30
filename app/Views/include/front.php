<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/assets/css/style.css">
        <style>
            .disabled{
                pointer-events: none !important;
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <div class="header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <a style="text-decoration: none;" href="/">
                    <h2 class="company-name">Adoptable Allies</h2>
                    </a>
                    <div class="d-flex justify-content-between icons" style="gap: 10px;">
                        <a href="/blogs" style="text-decoration: none;color:white;">Blogs</a>
                        <a href="/my-cart"><img src="/assets/images/shopping-cart.png"></a>
                        <a href="/login"><img src="/assets/images/profile.png"></a>
                        <img src="/assets/images/notification.png" id="notifbtn" style="cursor: pointer;"  class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu" id="dropdown-menu" style="width: 166px;height:300px;">
                            
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <?= $this->renderSection('scripts'); ?>

    <script>
        $('#notifbtn').on('click',function(){
            getNotification();
        });

        function getNotification(){
            $.ajax({
                url:'/notification',
                method:'get',
                success:function(res){
                    res = JSON.parse(res);
                    if(res.status == 400){
                        event.preventDefault();
                        alert(res.message);
                        window.location.href='/login';
                    }else{
                        data = res.data;
                        html = '';
                        $.each(data,function(index,value){
                            html += '<div class="dropdown-item" style="white-space:normal;padding-bottom:10px;border-bottom:1px solid #e9e9e9;text-decoration:none;">';
                            html += '<a href="/'+value.link+'">'+value.message+'</a>';
                            html += '</div>';
                        });
                        if(html == ''){
                            html = 'No notification found';
                        }
                        $('#dropdown-menu').html(html);
                    }
                }
            });
        }
    </script>


</html>
