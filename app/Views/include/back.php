
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->

    <meta name="title" content="Adoptable Allies" />

    <title>Adoptable Allies</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="/assets/css/adminlte.min.css">
        <style>
        .collab-count{
            padding: 0;
        }
        .contact-count{
            padding: 0;
        }

        .main-img-wrapper img{
            height: 100%;
            width: 100%;
            object-fit: contain;
            background: white;
            padding: 2px;

        }
        .documenet-wrapper .figure{
            display: inline-block;
            width: 45%;
            height: 300px;
            overflow: hidden;
            margin-left: 20px;
            position: relative;
        }
        .documenet-wrapper .figure img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .documenet-wrapper .figure a{
            position: absolute;
            top: 0px;
            right: 6px;
            color: red;
            z-index: 5;
            font-size: 30px;
        }
    </style>
    <?= $this->renderSection('style'); ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link"><i class="fa-solid fa-eye"></i><sub>Live</sub></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <div id="total-notification">

                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><span class="total-notif"></span> Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="https://infinconsultants.com/collaborator/list" class="dropdown-item" id="collab-count">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="https://infinconsultants.com/contact/list" class="dropdown-item" id="contact-count">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="/admin/dashboard" class="brand-link">
                <div class="main-img-wrapper">
                    <img src="/assets/images/user-regular.svg" alt="Adoptable Allies" class="brand-image img-circle elevation-3" style="opacity: .8">
                </div>
                <span class="brand-text font-weight-light"><?= $user->name; ?></span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php if( $user->type == 0 ):?>
                            <li class="nav-item">    
                                <a href="/admin/dashboard" class="nav-link <?= (getUrlSegment(1)=='dashboard')?'active':'' ?>">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/pets" class="nav-link <?= (getUrlSegment(1) == 'pets')?'active':'' ?>">
                                    <i class="nav-icon fa-solid fa-paw"></i>
                                    <p>
                                        Pet Category
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/donations" class="nav-link <?= (getUrlSegment(1) == 'donations')?'active':'' ?>">
                                    <i class="nav-icon fa fa-donate"></i>
                                    <p>
                                        Donations
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/product/lists" class="nav-link <?= (getUrlSegment(1) == 'product')?'active':'' ?>">
                                    <i class="nav-icon fa fa-product-hunt"></i>
                                    <p>
                                        Products
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/blog/lists" class="nav-link <?= (getUrlSegment(1) == 'blog')?'active':'' ?>">
                                    <i class="nav-icon fa fa-blog"></i>
                                    <p>
                                        Blogs
                                    </p>
                                </a>
                            </li>
                        <?php endif ?>
                        <?php if( $user->type == 2 ):?>
                        <li class="nav-item">
                            <a href="/admin/pet-lists" class="nav-link <?= (getUrlSegment(1) == 'pet-lists')?'active':'' ?>">
                                <i class="nav-icon fa-solid fa-cat"></i>
                                <p>
                                    Pet Lists
                                </p>
                            </a>
                        </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="/profile" class="nav-link <?= (getUrlSegment(0) == 'profile')?'active':'' ?>">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <?php if( $user->type == 1 ):?>
                        <li class="nav-item">
                            <a href="/my-cart" class="nav-link <?= (getUrlSegment(0) == 'my-cart')?'active':'' ?>">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>
                                    My Cart
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/my-order" class="nav-link <?= (getUrlSegment(0) == 'my-order')?'active':'' ?>">
                            <i class="fa-solid fa-bag-shopping"></i>
                                <p>
                                    My Order
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/savedlist" class="nav-link <?= (getUrlSegment(0) == 'savedlist')?'active':'' ?>">
                            <i class="fa-solid fa-bookmark"></i>
                                <p>
                                    My Saved List
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/adoptionresponse" class="nav-link <?= (getUrlSegment(0) == 'adoptionresponse')?'active':'' ?>">
                            <i class="fa-solid fa-bookmark"></i>
                                <p>
                                    My Adoption Requests
                                </p>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>
                    
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">
            
        <?= $this->renderSection('content'); ?>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="https://infinconsultants.com">Adoptable Allies</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 0.0.1
            </div>
        </footer>
    </div>



    <script src="/assets/js/jquery.min.js"></script>

    <script src="/assets/js/boostrap.bundle.js"></script>

    <script src="/assets/js/adminlte.min.js"></script>
    <?= $this->renderSection('scripts'); ?>


</body>

</html>
