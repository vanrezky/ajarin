<?= $this->extend('frontend/template'); ?>
<?= $this->section('content'); ?>
<section class="section confirmation">
    <div class="row justify-content-center ">
        <div class="col-lg-6 col-md-10 ">
            <div class="appoinment-wrap mt-5 mt-lg-0">
                <h2 class="mb-2 title-color">Sign Up As Student</h2>
                <p class="mb-4">Please fill in the required data to create an account.</p>
                <?= session('message'); ?>
                <form id="#" class="appoinment-form" method="post">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_name" id="student_name" type="text" value="<?= old('student_name'); ?>" class="form-control" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_birthdate" id="student_birthdate" type="date" value="<?= old('student_birthdate'); ?>" class="form-control" placeholder="Birth Date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_email" id="student_email" type="email" value="<?= old('student_email'); ?>" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_phonenumb" id="student_phonenumb" type="text" value="<?= old('student_phonenumb'); ?>" class="form-control" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_username" id="student_username" type="text" value="<?= old('student_username'); ?>" class="form-control" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="student_password" id="student_password" type="password" value="<?= old('student_password'); ?>" class="form-control" placeholder="Password">
                            </div>
                        </div>


                    </div>


                    <button type="submit" class="btn btn-main btn-round-full">Sign Up <i class="icofont-simple-right ml-2  "></i></button>
                    <!-- <a href="/signin?act=student" class="btn btn-main btn-round-full">Sign In <i class="icofont-simple-right ml-2  "></i></a> -->

                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>