<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>
    <?php if(empty($list)){ ?>
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
            <div class="container" style="margin-top: 30px;">
                <div class="pagination-wrapper" style="font-weight: 500;font-size:18px;">
                    <p>Displaying <?= $pagination['start'] ?> to <?= $pagination['end'] ?> of <?= $pagination['blog_list'] ?> Blog posts</p>
                </div>
                <div class="blog-list-wrapper" style="margin-top: 30px;">

                    <?php foreach($list as $l){ ?>
                        <div class="blog-item-wrapper d-flex" style="width: 100%;border:1px solid #000000;margin-bottom:30px;">
                            <div class="blog-figure" style="width: 325px;">
                                <img src="/<?= $l['banner_image']; ?>" class="imgage" style="width: 100%;height:100%;object-fit:cover">
                            </div>
                            <div class="blog-text-wrapper" style="padding: 20px;">
                                <h3 style="font-size: 40px;font-weight:600;"><?= $l['title']; ?></h3>
                                <p class="summary" style="font-size: 18px;font-weight:400;"><?= $l['summary']; ?></p>
                                <a class="btn btn-primary" href="/blog/detail/<?= $l['id']; ?>">Read More</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="bottom-pagination-wrapper" style="width: 100%;display:flex;justify-content:center;align-items:center;gap:10px;margin-bottom:30px;">
                        <?php for($i=0;$i < $pagination['pages']; $i++){ ?>
                            <div class="page-wrap" style="cursor:pointer;width: 20px;height:20px;background:#<?= ($pagination['curr_page'] == ($i+1))?'1E1E1E':'D9D9D9'; ?>;"></div>
                        <?php } ?>
                        
                        <!-- <div class="page-wrap" style="cursor:pointer;width: 20px;height:20px;background:#D9D9D9;"></div>
                        <div class="page-wrap" style="cursor:pointer;width: 20px;height:20px;background:#1E1E1E;"></div>
                        <div class="page-wrap" style="cursor:pointer;width: 20px;height:20px;background:#D9D9D9;"></div> -->
                </div>
            </div>
        </div>
    <?php } ?>


    <?= $this->endSection(); ?>