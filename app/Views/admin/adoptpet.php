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
                <h1 class="m-0"><?= $pet['name']; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?= $pet['name']; ?></li>
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
                <th>User Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $l=0; foreach($adopt_req as $p){ ?>
                <tr>
                    <td><?php $l++; echo $l; ?></td>
                    <td><?= $p['fullname']; ?></td>
                    <td><?= $p['number'] ?></td>
                    <td><?= $p['email'] ?></td>
                    <td>
                        <a data-id="<?= $p['id']; ?>" class="btn btn-success viewDetails">info</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Personal Information</h3>
        <hr>
        <div class="mb-3"><strong>Full Name : </strong><span id="fullname"></span></div>
        <div class="mb-3"><strong>Number : </strong><span id="number"></span></div>
        <div class="mb-3"><strong>Email : </strong><span id="email"></span></div>
        <div class="mb-3"><strong>Home Address : </strong><span id="home_address"></span></div>

        <hr>
        <h3 class="text-center">Living Arrangemets</h3>
        <hr>
        <div class="mb-3">
            <h6><strong>Do you own or rent your home?</strong></h6>
            <span id="ownorRent"></span>
        </div>
         
        <div class="mb-3">
            <h6><strong>If renting, do you have permission from your landlord to have a pet?</strong></h6>
            <span id="landlordPermission"></span>
        </div>
        <hr>
            <h3 class="text-center">Previous Pet Experience</h3>
        </hr>
        <div class="mb-3">
            <h6><strong>Have you owned pets before?</strong></h6>
            <span id="ownedPetsBefore"></span>
        </div>

        <div class="mb-3">
            <h6><strong>Experience Description:</strong></h6>
            <p id="experienceDescription"></p>
        </div>

        <hr>
            <h3 class="text-center">Additional Information</h3>
        </hr>
        <div class="mb-3">
            <h6><strong>Why do you want to adopt a pet?</strong></h6>
            <p id="adoptionReason"></p>
        </div>
        <div class="mb-3">
            <h6><strong>Are you open to adopting a pet with special needs?</strong></h6>
            <span id="openToSpecialNeeds"></span>
        </div>
        <form method="POST" action="/request/approval">
            <input type="hidden" id="adopt_id" name="adopt_id">
            <div class="form-group">
                <label for="accept">Request Approval</label>
                <select class="form-control approvalSelect" name="approval">
                    <option value="">-----</option>
                    <option value="accept">Accept</option>
                    <option value="reject">Reject</option>
                </select>
            </div>
            <div id="othercols"></div>
        </form>
      </div>
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
    $('.viewDetails').on('click',function(){
        curr_id = $(this).data('id');
        $('#adopt_id').val(curr_id);
        $.ajax({
            url:'/admin/getadoptdata/'+curr_id,
            type:'POST',
            success:function(res){
                res = JSON.parse(res);
                if(res.status == 200){
                    $('#fullname').html(res.detail.fullname);
                    $('#number').html(res.detail.number);
                    $('#email').html(res.detail.email);
                    $('#home_address').html(res.detail.home_address);

                    $('#ownorRent').html(res.detail.ownorRent);
                    $('#landlordPermission').html(res.detail.landlordPermission);
                    $('#ownedPetsBefore').html(res.detail.ownedPetsBefore);
                    $('#experienceDescription').html(res.detail.experienceDescription);

                    $('#adoptionReason').html(res.detail.adoptionReason);
                    $('#openToSpecialNeeds').html(res.detail.openToSpecialNeeds);

                    $('#exampleModalCenter').modal('show');

                    if(res.approval_res){
                        response = JSON.parse(res.approval_res.response);
                        console.log(response);
                        $('.approvalSelect').find('option[value="'+response.approval+'"]').prop('selected',true);
                        $('.approvalSelect').attr('style','pointer-events:none;');
                        if(response.approval == 'accept'){
                            ht = '<h6><strong>Meeting Date : </strong> '+response.datetime+'</h6>';
                            ht += '<h6><strong>Location : </strong>'+response.location+'</h6>';
                        }else{
                            ht = '<h6><strong>Reason : </strong></h6>';
                            ht += '<p>'+response.reason+'</p>'
                        }
                        $('#othercols').html(ht)
                    }
                }
            }
        });
    });

    $('.approvalSelect').on('change',function(){
        approval = $(this).val();
        if(approval == 'accept'){
            html = '<div class="form-group"><label for="datetime">Date and Time of Meeting:</label><input type="datetime-local" name="datetime" id="datetime" class="form-control"></div>';
            html += '<div class="form-group"><label for="location">Location</label><input type="text" name="location" id="location" class="form-control"></div>';
            html +='<button class="btn btn-primary" type="submit">Send</button>';
            $('#othercols').html(html);
        }else if(approval == 'reject'){
            html = '<div class="form-group"><label for="reasons">Reason for Rejection :</label><input type="text" name="reason" class="form-control"></div>';
            html +='<button class="btn btn-primary" type="submit">Send</button>';
            $('#othercols').html(html);
        }else{
            $('#othercols').html('');
        }
    });
</script>

<?= $this->endsection(); ?>
