<?= $this->extend('include/back'); ?>

<?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Donations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Donations</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">

    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $l=0; foreach($list as $p){ ?>
                <tr>
                    <td><?php $l++; echo $l; ?></td>
                    <td><?= $p['name']; ?></td>
                    <td><?= $p['email']; ?></td>
                    <td><?= $p['phone']; ?></td>
                    <td><?= $p['amount']; ?></td>

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
