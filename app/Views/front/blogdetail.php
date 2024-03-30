<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>
    <?php if(empty($blog)){ ?>
        <div class="container" style="margin-top: 75px;font-size: 42px;font-weight: 600;">
            <div class="text-body w-100 d-flex justify-content-center align-items-center" style="height: 70vh;">
                No Data Found
            </div>
        </div>
    <?php }else{ ?>
        <div class="blog-wrapper" style="margin-top: 87px;">
            <div class="blog-banner" style="background: url('/assets/images/blog_banner.jpg');padding:80px 0;">
                <h2 class="text-center" style="font-size:48px;font-weight: 700; color:#DFAE00;">Welcome TO Blogs</h2>
            </div>
        </div>
        <div class="container">
            
                    <h1 style="margin: 30px 0;font-weight:600;"><?= $blog['title']; ?></h1>
                    <p class="description" style="font-size: 18px;font-weight:400;"><?= $blog['summary']; ?></p>
                    <div class="blog-banner-wrapper" style="height: 400px;">
                        <img src="/<?= $blog['banner_image'] ?>" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="description-wrapper" style="font-size: 18px;margin-top: 30px;">
                        <?= $blog['description']; ?>
                    </div>
        </div>
    <?php } ?>


    <?= $this->endSection(); ?>