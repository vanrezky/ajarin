<?= $this->extend('frontend/template'); ?>
<?= $this->section('content'); ?>
<section class="section confirmation">
    <div class="row justify-content-center ">
        <div class="col-lg-6 col-md-10 ">
            <div class="appoinment-wrap mt-5 mt-lg-0">
                <h2 class="mb-2 title-color">Sign In As Student</h2>
                <p class="mb-4">Please log in first before doing activities.</p>
                <?= session('message'); ?>
                <form id="#" class="appoinment-form" method="post">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input name="username" id="name" type="text" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-main btn-round-full">Sign in <i class="icofont-simple-right ml-2"></i></button>
                    <a class="btn btn-main btn-round-full" href="/signup">Create Account <i class="icofont-simple-right ml-2"></i></a>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>