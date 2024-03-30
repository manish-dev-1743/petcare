<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>
        <!-- Banner -->
        <div class="banner">
            <div class="banner-image">
                <img src="assets/images/banner-img.jpg" class="banner-btn">
            </div>
            <div class="inner-text">
                <h2>ADOPT US.<br>WE NEED YOUR HELP</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.<br>
                    <a href="/about">Read more</a>

                </p>
                <form action="/pet/search" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="petname" placeholder="Search for a pet to adopt....">
                        <div class="form-icons d-flex justify-content-between">
                            <img src="assets/images/search.png" class="search-btn">
                            <img src="assets/images/filter.png" class="filter-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="dropdown-menu">
                                <?php foreach($category as $cat){?>
                                    <div class="dropdown-item">
                                        <label for="<?php echo $cat['slug']; ?>"><input type="checkbox" value="<?php echo $cat['id']; ?>" name="pet[]" id="<?php echo $cat['slug']; ?>">&nbsp;<?php echo $cat['name']; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Slider -->
        <div class="category-wrap">
            <div class="slider-wrapper">
                <div class="container">
                    <!-- Slider main container -->
                    
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <?php foreach($category as $cat){ ?>
                                <div class="swiper-slide"><a href="/pet/<?= $cat['slug']; ?>"><img src="<?= '/'.$cat['banner_image']; ?>"></a></div>
                            <?php } ?>
                            
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                
                </div>
            </div>
        </div>

        <div class="pet-supplies">
            <div class="container">
                <h2>Find Supplies for your Pets</h2>
                <div class="supplies-list">
                    <div class="row">
                        <?php foreach($products as $prod){ ?>
                            <div class="col-md-4">
                                <div class="list-item">
                                    <div class="item-image">
                                        <img src="<?= $prod['banner_image']; ?>">
                                    </div>
                                    <div class="item-detail">
                                        <a href="/product/<?= $prod['id']; ?>" style="text-decoration: none;">
                                            <h3><?= $prod['title']; ?></h3>
                                        </a>
                                        <div class="inner-text">
                                            <div class="price">
                                                Rs. <?= $prod['price']; ?>
                                            </div>
                                            <div class="cart-btn">
                                            <button class="btn btn-success addcart" data-product="<?= $prod['id']; ?>"><img src="/assets/images/shopping-cart.png"> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                    </div>
                    <div class="more-button">
                        <button class="btn btn-success">See More</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="donation-banner">
            <img src="assets/images/banner-2.png">
            <div class="inner-text">
                <h2>Help us help them.</h2>
                <p>Donate for a better life of animals.</p>
                <a class="btn" data-toggle="modal" data-target="#donationModal">Donate Now</a>
            </div>
        </div>
        <div class="modal fade" id="donationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donation Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/donate-now" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="text" name="number" id="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Donate via Esewa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    <?= $this->endSection(); ?>

    <?= $this->section('scripts');?>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
                spaceBetween: 0,
                pagination: {
                el: ".swiper-pagination",
                clickable: true,
                },
                breakpoints: {
                    320: {
                    slidesPerView: 2,
                    },
                    768: {
                    slidesPerView: 3,
                    },
                },
            });
            $('.addcart').on('click',function(){
                <?php if(session()->get('token') !== NULL){ ?>
                    $.ajax({
                        url : '/cart/add',
                        type : 'POST',
                        data : {
                            product_id:$(this).attr('data-product'),
                            quantity : $('.quantitiy').innerHTML
                        },
                        success : function(res){
                            res = JSON.parse(res);
                            if(res.status == 200){
                                alert(res.message);
                            }
                        }
                    });
                <?php }else{ ?>
                    window.location.href = '/login';
                <?php } ?>
    
            });
        </script>

    <?= $this->endSection(); ?>
