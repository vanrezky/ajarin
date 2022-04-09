<?= $this->extend('frontend/template'); ?>
<?= $this->section('content'); ?>
<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">All Teacher</span>
                    <h1 class="text-capitalize mb-5 text-lg">Best teacher</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section doctors">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Welcome <?= session('_ci_user_login.name'); ?>..</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p>We provide a wide range of creative services adipisicing elit. Autem maxime rem modi eaque, voluptate. Beatae officiis neque </p>
                </div>
            </div>
        </div>

        <div class="col-12 text-center  mb-5">
            <div class="btn-group btn-group-toggle " data-toggle="buttons">
                <label class="btn active ">
                    <input type="radio" name="shuffle-filter" value="all" checked="checked" />All Subjects
                </label>
                <label class="btn ">
                    <input type="radio" name="shuffle-filter" value="english_language" />English Language
                </label>
                <label class="btn">
                    <input type="radio" name="shuffle-filter" value="mathematics" />Mathematics
                </label>
            </div>
        </div>
        <div class="row shuffle-wrapper portfolio-gallery">

            <?php foreach ($teachers as $key => $value) : ?>
                <?php
                // $homebase = json_decode($value['teacher_homebase'], true);
                // $hb = "";
                // foreach ($homebase as $k => $v) {
                //     $hb .= "&quot;$v&quot;";
                // }

                ?>
                <div class="col-lg-3 col-sm-6 col-md-6 mb-4 shuffle-item" data-groups='<?= $value['teacher_homebase']; ?>'>
                    <div class="position-relative doctor-inner-box">
                        <div class="doctor-profile">
                            <div class="doctor-img rect-img-container">
                                <img src="/uploads/images/<?= $value['teacher_image']; ?>" alt="doctor-image" class="img-fluid w-100 img-thumbnail rect-img">
                            </div>
                        </div>
                        <div class="content mt-3">
                            <h4 class="mb-0"><a href="/student/teacher-detail?id=<?= $value['teacher_id'] ?>"><?= $value['teacher_name']; ?></a></h4>
                            <p>Since <?= date('F j, Y', strtotime($value['register_date'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<style>
    .rect-img-container {
        position: relative;
    }

    .rect-img-container::after {
        content: "";
        display: block;
        padding-bottom: 100%;
    }

    .rect-img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<?= $this->endSection(); ?>