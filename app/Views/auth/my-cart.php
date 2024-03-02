<?= $this->extend('include/back'); ?>

<?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <style>
        .banner-img{
            width: 80px;
            height: 80px;
        }
        .banner-img img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .cart-total-wrapper{
            margin-right: 5px;
            width: 100%;
            border: 1px solid black;
        }
        .cart-total-wrapper .sub-total{
            padding: 10px 8px;
            margin-bottom: 1px solid black;
        }
    </style>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">My Cart</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">My Cart</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
            <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $l=0; $total_amt=0; foreach($cart_list as $cl){ ?>
                    <tr>
                        <td><?php $l++; echo $l; ?></td>
                        <td><div class="banner-img"><img src="/<?= $cl['details']['banner_image']; ?>"></div><div class="name-title"><?= $cl['details']['title']; ?></div></td>
                        <td><?= $cl['details']['price'] ?></td>
                        <td><?= $cl['cart_detail']['quantity']; ?></td>
                        <?php $total_amt += ($cl['cart_detail']['quantity']*$cl['details']['price']); ?>
                        <td><?= ($cl['cart_detail']['quantity']*$cl['details']['price']); ?></td>
                        <td><a href="/delete/cart/<?= $cl['cart_detail']['id'] ?>"><i class="fa fa-times-circle" style="color:red;"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
            </div>
            <div class="col-sm-4">
                    <h3 class="text-center mb-3"> Cart Total</h3>
                    <div class="cart-total-wrapper">
                        <div class="sub-total d-flex justify-content-between align-items-center">
                                <h4>Sub Total</h4>
                                <div class="amount">Rs. <?= $total_amt; ?></div>
                        </div>
                        <div class="sub-total d-flex justify-content-between align-items-center">
                            <h4>Shipping</h4>
                            <div class="shipping-content">
                                <h6>Flat Rate : <strong>Rs 100</strong></h6>
                                <h6>Shipping to <strong>Bagmati</strong></h6>
                                <h6 style="color: red;">Change Address</h6>
                            </div>
                        </div>
                        <div class="sub-total d-flex justify-content-between align-items-center">
                            <h4>Total</h4>
                            <div class="amount">Rs. <?= ($total_amt+100); ?></div>
                        </div>
                    </div>
                    <div class="checkout-payment mt-3">
                        <button class="btn btn-primary">Proceed to Payment</button>
                    </div>
            </div>
        </div>


    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>
    let table = new DataTable('#myTable', {
        responsive: true
    });
</script>

<?= $this->endsection(); ?>