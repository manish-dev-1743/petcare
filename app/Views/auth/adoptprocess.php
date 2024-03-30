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
                <h1 class="m-0">Adoption Requests</h1>
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
                        <th>User Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $l=0; foreach($al as $cl){ ?>
                        <tr>
                            <td><?php $l++; echo $l; ?></td>
                            <td><?= $cl['fullname']; ?></td>
                            <td><?= $cl['number']; ?></td>
                            <td><?= $cl['email']; ?></td>
                            <td>
                                <?php if(isset($rl[$cl['id']])){ ?> 
                                    <a class="btn btn-primary responsebtn" data-msg="<?= $cl['id']; ?>">View Resopnse</a>
                                <?php }else{ echo 'No Response'; } ?>
                           </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adoption Response</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <h2 class="text-center" id="aprroval-title"></h2>
            <div class="content-approval" id="approval-content">

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
    let response_list = <?= json_encode($rl); ?>;
    $('.responsebtn').on('click',function(){
        data = $(this).data('msg');
        msg= response_list[data];
        res = JSON.parse(msg.response);
        if(res.approval == 'accept'){
            $('#aprroval-title').html('Congratulations !!!');
            $('#aprroval-title').css('color','green');
            html = '<strong>Time of Meeting : </strong>';
            html += res.datetime;
            html += '<br><strong>Location : </strong>';
            html += res.location;

        }else{
            $('#aprroval-title').html('Sorry !!!');
            $('#aprroval-title').css('color','red');
            html = "<strong>We are sorry to infrom your request has been rejected. </strong>";
        }
        $('#approval-content').html(html);
        $('#exampleModal').modal('show');
    });
    $('[data-dismiss="modal"]').on('click',function(){
        $('#exampleModal').modal('hide');
    });
</script>


<?= $this->endsection(); ?>