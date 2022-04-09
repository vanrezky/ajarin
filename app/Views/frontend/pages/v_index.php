<?= $this->extend('frontend/template'); ?>
<?= $this->section('content'); ?>

<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-xl-7">
                <div class="block">
                    <div class="divider mb-3"></div>
                    <span class="text-uppercase text-sm letter-spacing ">Education Solution</span>
                    <h1 class="mb-3 mt-3">Welcome To Ajarin </h1>
                    <div class="btn-container">
                        <?php if (session()->has('_ci_user_login')) { ?>
                            <a href="/<?= session('_ci_user_login.level'); ?>" class="btn btn-main-2 btn-icon btn-round-full">List..<i class="icofont-simple-right ml-2  "></i></a>
                        <?php } else { ?>
                            <a href="/appoinment" class="btn btn-main-2 btn-icon btn-round-full">Sign In <i class="icofont-simple-right ml-2  "></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section testimonial-2 gray-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-title text-center">
                    <h2>We served over 5000+ Patients</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p>Lets know moreel necessitatibus dolor asperiores illum possimus sint voluptates incidunt molestias nostrum laudantium. Maiores porro cumque quaerat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>