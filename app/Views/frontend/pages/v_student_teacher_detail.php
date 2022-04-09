<?= $this->extend('frontend/template'); ?>

<?= $this->section('content'); ?>

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Teacher Details</span>
                    <h1 class="text-capitalize mb-5 text-lg"><?= $teacher['teacher_name']; ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section doctor-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="doctor-img-block">
                    <img src="/uploads/images/<?= $teacher['teacher_image']; ?>" alt="" class="img-fluid w-100">

                    <div class="info-block mt-4">
                        <h4 class="mb-0"><?= $teacher['teacher_name']; ?></h4>
                        <?php
                        $homebase = json_decode($teacher['teacher_homebase'], true);
                        $hb = "";
                        foreach ($homebase as $k => $v) {
                            $hb .= teacher_homebase($v) . ", ";
                        }; ?>
                        <p><?= $hb; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-6">
                <div class="doctor-details mt-4 mt-lg-0">
                    <h2 class="text-md">Introducing to myself</h2>
                    <div class="divider my-4"></div>
                    <p><?= $teacher['teacher_desc']; ?></p>

                    <a href="discuss?id=<?= $teacher['teacher_id']; ?>" class="btn btn-main-2 btn-round-full mt-3">Start discussion<i class="icofont-simple-right ml-2  "></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>