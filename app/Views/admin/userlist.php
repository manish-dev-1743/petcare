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
                <h1 class="m-0">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
<div class="row">
    <div class="col-md-6">
        <h2 class="text-center">Users List</h2>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $l=0; foreach($users[1] as $p){ ?>
                    <tr>
                        <td><?php $l++; echo $l; ?></td>
                        <td><?= $p['email']; ?></td>
                        <td><?= $p['phone']; ?></td>
                        <td>
                            <?php if($p['status'] == 1){ ?>
                                    <a href="/admin/users/changestatus/<?= $p['id']; ?>" class="btn btn-danger">Terminate</a>
                                <?php }else{ ?>
                                    <a href="/admin/users/changestatus/<?= $p['id']; ?>" class="btn btn-primary">Activate</a>
                                    <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
    <h2 class="text-center">Allies List</h2>
        <table id="myTable2" class="display">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $l=0; foreach($users[2] as $p){ ?>
                    <tr>
                        <td><?php $l++; echo $l; ?></td>
                        <td><?= $p['email']; ?></td>
                        <td><?= $p['phone']; ?></td>
                        <td>
                            <?php if($p['status'] == 1){ ?>
                                    <a href="/admin/users/changestatus/<?= $p['id']; ?>" class="btn btn-danger">Terminate Allies</a>
                                <?php }else{ ?>
                                    <a href="/admin/users/changestatus/<?= $p['id']; ?>" class="btn btn-primary">Activate Allies</a>
                                    <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>
<?= $this->endsection(); ?>



<?= $this->section('scripts'); ?>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>
    let table = new DataTable('#myTable', {
        responsive: true
    });

    let table2 = new DataTable('#myTable2', {
        responsive: true
    });
</script>

<?= $this->endsection(); ?>
