<?= $this->extend('include/front') ?>

<?= $this->section('content') ?>
<div class="login-page">
    <div class="container">
        <div class="inner-login-page">
            <img src="/assets/images/banner-3.png">
            <div class="inner-text">
                <h2>
                    Hello, hooman! Sign in to access your free PetRescue features & pawsome tools.
                </h2>
                <?php if(session()->has('success')) : ?>
                    <div class="alert alert-success">
                        <?= session('success') ?>
                    </div>
                <?php endif ?>
                <?php if (session()->has('errors')) : ?>
                    <div style="color: red;">
                        <ul>
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="/do-login" method="POST">
                    <div class="form-group">
                        <label for="user">
                            Email
                        </label>
                        <div class="input-container">
                            <input name="email" type="text" class="form-control">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user">
                            Password
                        </label>
                        <div class="input-container">
                            <input name="password" type="text" class="form-control">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" class="btn submitbtn">Log In</button>
                    </div>
                </form>
                <div class="no-account">
                    <p>Don't have an account?  <a href="/register">Sign Up</a></p>
                    <a href="#"><p class="help">Need Help?</p></a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?= $this->endSection() ?>
