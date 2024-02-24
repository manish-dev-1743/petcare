<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>

    <?php if(empty($animal)){ ?>
        <div class="container" style="margin-top: 75px;font-size: 42px;font-weight: 600;">
            <div class="text-body w-100 d-flex justify-content-center align-items-center" style="height: 70vh;">
                No Data Found
            </div>
        </div>
    <?php }else{ ?>
        <div class="pet-page">
            <div class="container">
                <div class="pet-image">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <?php foreach($animal['images'] as $imgs){ ?>
                                <div class="swiper-slide"><img src="<?= '/'.$imgs['image']; ?>"></div>
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="pet-description">
                    <div class="data-body">
                        <h2><?= $animal['name']; ?></h2>
                        <p class="description">
                            <?= $animal['description']; ?>
                        </p>
                        <div class="btn-wrapper">
                            <a href="#" class="btn">Adopt this pet </a>
                            <div class="icon-wrapper">
                                <a href="#" class="btn">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </a>
                                <a href="#" class="btn">
                                    <i class="fa-solid fa-bookmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
           
        </div>
    <?php } ?>


    <?= $this->endSection(); ?>

    <?= $this->section('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 3,
          spaceBetween: 0,
          freeMode: true,
          loop:true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
        });
      </script>
    <?= $this->endSection(); ?>

