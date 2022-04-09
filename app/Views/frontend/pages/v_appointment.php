<?= $this->extend('frontend/template'); ?>
<?= $this->section('content'); ?>


<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Sign in to Your account Seat</span>
                    <h1 class="text-capitalize mb-5 text-lg">Sign in As</h1>
                    <a class="btn btn-main btn-round-full" href="signin?act=teacher">I'am A Teacher<i class="icofont-simple-right ml-2"></i></a>
                    <a class="btn btn-main btn-round-full" href="signin?act=student">I'am A Student<i class="icofont-simple-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>