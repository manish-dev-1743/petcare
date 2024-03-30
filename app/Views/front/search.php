<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>
    <div class="container" style="margin-top: 100px;">
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="searchtext">Name : </label>
                    <input type="text" name="petname" class="form-control" id="searchtext" value="<?php echo $formdata['petname']?>">
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <div class="form">
                    <label for="category" class="filter-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pet Category : </label>
                    <div class="dropdown-menu">
                        <?php foreach($pet_category as $cat){?>
                            <div class="dropdown-item">
                                <label for="<?php echo $cat['slug']; ?>"><input <?= (isset($formdata['pet']) && in_array($cat['id'],$formdata['pet']))?'checked':'' ?> type="checkbox" value="<?php echo $cat['id']; ?>" name="pet[]" id="<?php echo $cat['slug']; ?>">&nbsp;<?php echo $cat['name']; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="age">Age(IN YEARS) : </label>
                    <input type="text" name="age" value="<?= (isset($formdata['age']))?$formdata['age']:'' ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="breed">Breed : </label>
                    <input type="text" name="breed" value="<?= (isset($formdata['breed']))?$formdata['breed']:'' ?>" class="form-control">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="gender">Gender : </label>
                    <select class="form-control" name="gender" id="gender">
                        <option value="">--Select Gender--</option>
                        <option value="Male" <?= (isset($formdata['gender']) && $formdata['gender']=='Male')?'selected':'' ?>>Male</option>
                        <option value="Female" <?= (isset($formdata['gender']) && $formdata['gender']=='Female')?'selected':'' ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <button class="btn btn-outline-success" type="submit">Filter</button>
            </div>
        </div>

    </form>
    </div>
    <?php if(empty($list)){ ?>
        <div class="container" style="margin-top: 75px;font-size: 42px;font-weight: 600;">
            <div class="text-body w-100 d-flex justify-content-center align-items-center" style="height: 70vh;">
                No Data Found
            </div>
        </div>
    <?php }else{ ?>
        <div class="pet-supplies">
            <div class="container">
                <h2><?= $title; ?></h2>
                <div class="supplies-list">
                    <div class="row">
                        <?php foreach($list as $prod){ ?>
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