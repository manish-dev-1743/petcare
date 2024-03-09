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
  <!-- Include Leaflet CSS and JS files -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Saved List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Saved</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
 
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Pet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $l=0; foreach($saved as $cl){ ?>
                        <tr>
                            <td><?php $l++; echo $l; ?></td>
                            <td><div class="banner-img"><img src="/<?= $cl['pet_detail']['banner_image']; ?>"></div><div class="name-title"><?= $cl['pet_detail']['name']; ?></div></td>
                            <td>
                                <a href="/delete/saved/<?= $cl['id']; ?>" class="btn btn-danger">Remove</a>
                                <a href="/pets/<?= $cl['pet']['slug']; ?>/<?= $cl['pet_detail']['id']; ?>" class="ml-3 btn btn-primary">Detail</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


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