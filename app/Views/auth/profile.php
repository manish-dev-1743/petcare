<?= $this->extend('include/back'); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <form action="/user/profile/update" method="POST" enctype="multipart/form-data">
                    <div class="form-group float-right">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    <div class="form-group">
                        <label for="name">
                            Name
                        </label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $user_details['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">
                            Email
                        </label>
                        <input type="text" name="email" id="email" class="form-control" value="<?= $user_details['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">
                            Phone
                        </label>
                        <input type="phone" name="phone" id="phone" class="form-control" value="<?= $user_details['phone']; ?>">
                    </div>
                    <?php if($user_details['type'] == 2): ?> 
                        <div class="documenet-wrapper">
                                <label>Documents</label>
                                <input type="file" name="documents[]" class="form-control" placeholder="Add Documents" style="margin-bottom: 1rem;" multiple>
                                <?php if($user_details['documents'] != NULL && $user_details['documents'] != '[]'){
                                    $documents = json_decode($user_details['documents']);
                                    foreach($documents as $d){
                                    ?>
                                    <div class="figure">
                                        <img src="/<?= $d; ?>">
                                        <a href="/delete/document?path=<?= $d; ?>"><i class="fa-solid fa-circle-xmark"></i></a>
                                    </div>
                                <?php } } ?>
                            
                        </div>
                    <?php endif ?>
                
                </form>
            </div>
            <div class="col-md-5">
                <h2>Password Change</h2>
                <form action="/user/changePass" method="POST">
                    <div class="form-group float-right">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    <div class="form-group mb-3">
                            <input type="password" name="curr_pass" id="curr_pass" class="form-control" placeholder="Enter Current Password.">
                    </div>
                    <div class="form-group mb-3">
                            <input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="Enter New Password.">
                    </div>
                    <div class="form-group">
                            <input type="password" name="re_pass" id="re_pass" class="form-control" placeholder="Re-enter New Password.">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>