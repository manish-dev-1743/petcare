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
    </style>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pets</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Pets</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="button-container">
        <a href="/admin/pets/update" class="btn btn-primary float-right mb-4">Add Pet</a>
    </div>

    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Pet Category</th>
                <th>Banner Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $l=0; foreach($pets as $p){ ?>
                <tr>
                    <td><?php $l++; echo $l; ?></td>
                    <td><?= $p['name']; ?></td>
                    <td><div class="banner-img"><img src="/<?= $p['banner_image']; ?>"></div></td>
                    <td><?php if($p['status']){
                        echo '<span class="text-success">Active</span>';
                    }else{
                        echo '<span class="text-danger">Inactive</span>';
                    } ?></td>
                    <td>
                        <a href="/admin/pets/update?id=<?= $p['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="/admin/pets/delete?id=<?= $p['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<?= $this->endsection(); ?>



<?= $this->section('scripts'); ?>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>
    let table = new DataTable('#myTable', {
        responsive: true
    });
</script>

<?= $this->endsection(); ?>
