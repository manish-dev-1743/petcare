<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>

    <div class="signup-page allies">
            <div class="container">
                <div class="inner-signup-page">
                    <img src="/assets/images/signup.png">

                    <div class="inner-text">
                        <div class="allies-contnet">
                            <h2>Rescue Organization Sign Up</h2>
                            <?php if (session()->has('errors')) : ?>
                                <div style="color: red;">
                                    <ul>
                                        <?php foreach (session('errors') as $error) : ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                            <div class="details">
                                <h3>Personal Details</h3>
                                <p>This section is for your personal account and sign-in details.As the main account holder, your full details must be provided for verification and contact by PetRescue. We will send membership application updates and other PetRescue communications to the email address listed here.You can use the same email address for both your personal details and your organisation details (see next section) if you wish.</p>
                            </div>
                        </div>
      
                        <form action="/allies-signup" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Organization Name</label>
                                <input type="text" name="name"  class="form-control" placeholder="Enter Organization Name.">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter your Email">
                            </div>

                            <div class="form-group">
                                <label>Email Confirmation</label>
                                <input type="text" name="re-email" class="form-control" placeholder="Re-enter your mail">
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter your Phone Number.">
                            </div>

                            
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-container">
                                    <input name="password" type="password" class="form-control">
                                    <i class="fa-solid fa-eye eyebutton"></i>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <div class="input-container">
                                    <input name="re-pass" type="password" class="form-control">
                                    <i class="fa-solid fa-eye eyebutton"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Legal Documents</label>
                                <input name="documents[]" type="file" class="form-control" multiple>
                            </div>

                            <div class="form-group">
                                <span class="policy">By signing up, I agree to the <a href="#">Terms Of Use</a> and PetRescue's <a href="#">Privacy Policy</a></span>
                            </div>

                            <div class="button-container">
                                <button type="submit" class="btn">Sign Up</button>
                            </div>
                        </form>
                        <div class="have-account">
                            Already have an account? <a href="/login">Log In</a>
                        </div>

                    </div>
                </div>
            </div>
           
        </div>

    <?= $this->endSection(); ?>