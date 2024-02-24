<?= $this->extend('include/back'); ?>

<?= $this->section('style'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="/assets/css/image-uploader.min.css"></link>
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

    .image-wrapper{
        width: 100%;
        height: auto;
        margin-bottom: 20px;
    }
    .image-wrapper img{
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .deleteBtn{
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(-50%,-50%);
        color: red;
        z-index: 2;
        font-size: 20px;
    }
    .upload-text{
        cursor: pointer;
    }
</style>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Animal Update</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">animal</li>
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
   <?php if(!empty($animal)){ $animal = $animal[0]; } ?>
    <div class="container">
        <form action="/admin/animals/doupdate" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php if(isset($animal['id'])){ ?>
                            <input type="hidden" id="id" name="id" value="<?= $animal['id']; ?>">
                        <?php } ?>
                        <label for="cat-name">Name</label>
                        <input type="text" class="form-control" name="name" id="cat-name" value="<?= @$animal['name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="cat-slug">Pet Category</label>
                        <select class="form-control" name="pet_id">
                            <?php foreach($pet_cat as $pc){ ?>
                                <option value="<?= $pc['id']; ?>" <?php if($pc['id'] == @$animal['pet_id']){ echo 'selected'; } ?>><?= $pc['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="status" id="status"<?php if(@$animal['status']){ echo ' checked'; }?>>
                        <label for="status">Status</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="main-image">Banner Image</label>
                    <div class="img-wrapper">
                        <img src="/<?php echo @$animal['banner_image']; ?>" class="preview-image">
                        <input type="file" name="banner_image">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary btn-md">Update</button>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description"><?= @$animal['description']; ?></textarea>   
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label>Other Images</label>
                    <div class="input-field">
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                    </div>
                    <hr>
                    <div class="loaded-images">
                        <h2 class="text-center">Loaded Images</h2>
                        <?php if(empty($animal_images)){ ?>
                            <div class="w-100 mt-3 text-center"> No Images Uploaded </div>
                        <?php }else{ ?>
                        <div class="row">
                            <?php foreach($animal_images as $bi ){ ?>
                                <div class="col-md-2 position-relative">
                                    <div class="image-wrapper">
                                        <img src="/<?= $bi['image']; ?>">
                                    </div>
                                    <a href="/admin/animals/image/<?= $bi['id']; ?>" class="deleteBtn"><i class="fa-solid fa-circle-xmark"></i></a>
                                </div>
                            <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<?= $this->endsection(); ?>



<?= $this->section('scripts'); ?>

<script src="/ckeditor/ckeditor.js"></script>
<script src="/assets/js/image-uploader.min.js"></script>
<script>

    CKEDITOR.replace('description');

    $('.input-images-1').imageUploader({
        imageInputName: 'images',
        extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg']
    });

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
