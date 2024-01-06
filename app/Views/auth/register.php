<?= $this->extend('include/front') ?>

<?= $this->section('content') ?>
<div class="signup-page">
            <div class="container">
                <div class="inner-signup-page">
                    <img src="/assets/images/signup.png">
                    <div class="inner-text">
                        <h2>Sign Up</h2>
                        <?php if (session()->has('errors')) : ?>
                            <div style="color: red;">
                                <ul>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <form method="POST" action="/signup">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your Full name">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter your Email">
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
                                <span class="policy">By signing up, I agree to the <a href="#">Terms Of Use</a> and PetRescue's <a href="#">Privacy Policy</a></span>
                            </div>

                            <div class="button-container">
                                <button type="submit" class="btn">Sign Up</button>
                            </div>
                        </form>
                        <div class="have-account">
                            Already have an account? <a href="/login">Log In</a>
                        </div>

                        <div class="allies-account">
                            Are you a shelter, rescue group,organisation?<br> Join  <a href="allies.html">AdoptableAllies</a> now!
                        </div>
                    </div>
                </div>
            </div>
           
        </div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $('.eyebutton').on('click',function(){
        var inputField = $(this).parent().find('input');

        inputField.attr('type', 'text');
    
        setTimeout(function () {
            inputField.attr('type', 'password');
        }, 2000);
    });
</script>
<?= $this->endSection() ?>
