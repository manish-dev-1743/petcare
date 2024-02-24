<?= $this->extend('include/back'); ?>

<?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <style>
    .img-wrapper .preview-image{
        width: 100%;
        height: 200px;
        object-fit: contain;
        cursor: pointer;
    }
    .img-wrapper input{
        display: none;
    }
</style>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pets Update</h1>
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
    <?php if(isset($errors)){ ?>
        <span class="alert alert-danger">
            <?= $errors; ?>
        </span>
    <?php } ?>
   <?php if(!empty($pet)){ $pet = $pet[0]; } ?>
    <div class="container">
        <form action="/admin/pets/doupdate" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php if(isset($pet['id'])){ ?>
                            <input type="hidden" id="id" name="id" value="<?= $pet['id']; ?>">
                        <?php } ?>
                        <label for="cat-name">Category Name</label>
                        <input type="text" class="form-control" name="name" id="cat-name" value="<?= @$pet['name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="cat-slug">Cat Slug</label>
                        <input type="text" class="form-control" name="slug" id="cat-slug" value="<?= @$pet['slug']; ?>" style="pointer-events: none; background:#e9e9e9;">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="status" id="status"<?php if(@$pet['status']){ echo ' checked'; }?>>
                        <label for="status">Status</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="main-image">Banner Image</label>
                    <div class="img-wrapper">
                        <img src="/<?php echo @$pet['banner_image']; ?>" class="preview-image">
                        <input type="file" name="banner_image">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary btn-md">Update</button>
                </div>
            </div>
        </form>
    </div>

</div>
<?= $this->endsection(); ?>



<?= $this->section('scripts'); ?>

<script>
    $('#cat-name').on('keyup',function(){
        value = $('#cat-name').val();
        value = value.replace(' ','-').toLowerCase();
        $('#cat-slug').val(value);
    });
</script>

<script>


     $(function(){
        $('img').each(function(index,element){
            if($(this).attr('src') == '' || $(this).attr('src') == '/'){
                $(this).attr('src','/assets/images/default.png');
            }
        });
        $('.preview-image').on('click',function(){
            $(this).parent().children('input').trigger('click');
        });
    });

    $('.img-wrapper input').on('change', function() {
        previewImage(this);
    });

    function previewImage(input) {
        var preview = $('.preview-image')[0];
        var file = input.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = "/";
        }
    }
</script>

<?= $this->endsection(); ?>
