<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>

    <?php if(empty($animal)){ ?>
        <div class="container" style="margin-top: 75px;font-size: 42px;font-weight: 600;">
            <div class="text-body w-100 d-flex justify-content-center align-items-center" style="height: 70vh;">
                No Data Found
            </div>
        </div>
    <?php }else{ ?>
        <div class="pet-supplies" style="margin-top: 100px;">
            <div class="container">
                <h2>PET : <?= $title; ?></h2>
                <div class="supplies-list">
                    <div class="row">
                        <?php foreach($animal as $prod){ ?>
                            <div class="col-md-4">
                                <a href="/pets/<?= str_replace(' ','-',strtolower($title)).'/'.$prod['id']; ?>" style="text-decoration: none; color:red;">
                                <div class="list-item">
                                    <div class="item-image">
                                        <img src="<?= '/'.$prod['banner_image']; ?>">
                                    </div>
                                    <div class="item-detail text-center">
                                        <h3><?= $prod['name']; ?></h3>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <?= $this->endSection(); ?>