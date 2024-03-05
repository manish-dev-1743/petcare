<?= $this->extend('include/back'); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">My Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">My Orders</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php  foreach($my_orders as $mo ){ ?>
            <div class="row" style="background: #e9e9e9;padding: 10px;margin: 10px 0;">
                <div class="col-md-8" style="border-right: 1px solid white;">
                    <div class="product-wrapper mb-3 d-flex" style="overflow-x: scroll; max-width:100%;">
                        <?php $q_loop = 0; foreach($mo['products'] as $prod){ $quan = explode(',',$mo['quantity']); ?>
                        <div class="card w-25 mr-3">
                            <div class="card-header" style="width: 100%;height:100px;">
                                <img src="<?= $prod['banner_image']; ?>" style="width:100%;height:100%;object-fit:contain;">
                            </div>
                            <div class="card-body">
                                <h4><?= $prod['title']; ?></h4>
                                <p>Rs. <?= $prod['price']; ?></p>
                                <p>Quantity : <?= $quan[$q_loop]; ?></p>
                                <?php $q_loop++; ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3><strong>Rs.</strong><?= $mo['amount']; ?></h3>
                    <?php if($mo['is_paid']){ ?>
                        <p class="text-success"><i class="fas fa-check"></i> Paid</p>
                    <?php }else{ ?>
                        <p class="text-danger">Cash On Delivery</p>
                    <?php } ?>
                        <h4><strong>Delivery Date : </strong><?= date('Y-m-d',strtotime($mo['delivery_date'])); ?></h4>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?= $this->endSection(); ?>