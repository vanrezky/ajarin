<?= $this->extend('frontend/template'); ?>

<?= $this->section('content'); ?>

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section doctor-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="doctor-img-block text-center">
                    <img src="/uploads/images/<?= $profile['teacher_image']; ?>" alt="" class="img-fluid" style="max-width:200px">

                    <div class="info-block mt-4">
                        <h4 class="mb-0"><?= $profile['teacher_name']; ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-6">
                <?= session('message'); ?>
                <form id="" class="" method="post" action="" enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input name="teacher_name" id="teacher_name" type="text" value="<?= $profile['teacher_name']; ?>" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Birth Date</label>
                                <input name="teacher_birthdate" id="teacher_birthdate" type="date" value="<?= $profile['teacher_birthdate']; ?>" class="form-control" placeholder="Birth Date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="teacher_email" id="teacher_email" type="email" value="<?= $profile['teacher_email']; ?>" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input name="teacher_phonenumb" id="teacher_phonenumb" type="text" value="<?= $profile['teacher_phonenumb']; ?>" class="form-control" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input name="teacher_username" id="teacher_username" type="text" value="<?= $profile['teacher_username']; ?>" class="form-control" placeholder="Username" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input name="teacher_password" id="teacher_password" type="password" value="" class="form-control" placeholder="Password">
                                <small>leave it blank if you don't want to change the password</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Profile Picture</label>
                                <input name="teacher_image" id="teacher_image" type="file" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input class="btn btn-main btn-round-full" name="submit" type="submit" value="Update Profile">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>