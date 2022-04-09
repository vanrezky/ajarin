<?= $this->extend('backend/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <?= session('message'); ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    <a href="/admin/teacher" class="btn btn-warning btn-sm"> <i class="fas fa-chevron-left"></i> Back</a>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Fullname</label>
                                    <input type="text" class="form-control" name="teacher_name" id="teacher_name" aria-describedby="helpId" value="<?= isset($teacher['teacher_name']) ? $teacher['teacher_name'] : old('teacher_name'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Birth Date</label>
                                    <input type="date" class="form-control" name="teacher_birthdate" id="teacher_birthdate" aria-describedby="helpId" value="<?= isset($teacher['teacher_birthdate']) ? $teacher['teacher_birthdate'] : old('teacher_birthdate'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="number" class="form-control" name="teacher_phonenumb" id="teacher_phonenumb" aria-describedby="helpId" value="<?= isset($teacher['teacher_phonenumb']) ? $teacher['teacher_phonenumb'] : old('teacher_phonenumb'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="teacher_email" id="teacher_email" aria-describedby="helpId" value="<?= isset($teacher['teacher_email']) ? $teacher['teacher_email'] : old('teacher_email'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="teacher_username" id="teacher_username" aria-describedby="helpId" value="<?= isset($teacher['teacher_username']) ? $teacher['teacher_username'] : old('teacher_username'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="teacher_password" id="teacher_password" aria-describedby="helpId">
                                    <?= isset($teacher['teacher_password']) ? "<small>leave it blank if you don't want to change the password</small>" : '' ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Teacher Homebase</label>
                                    <?php
                                    $homebase = isset($teacher['teacher_homebase']) ? json_decode($teacher['teacher_homebase'], true) : [];
                                    foreach (teacher_homebases() as $val => $desc) {
                                        $checked = is_array($homebase) ? (in_array($val, $homebase) ? 'checked' : '') : '';
                                        echo '
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" ' . $checked . ' value="' . $val . '" name="teacher_homebase[]" class="custom-control-input" id="' . $val . '">
                                                <label class="custom-control-label" for="' . $val . '">' . $desc . '</label>
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea rows="5" class="form-control" name="teacher_desc" id="teacher_desc" aria-describedby="helpId"><?= isset($teacher['teacher_desc']) ? $teacher['teacher_desc'] : old('teacher_desc'); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Image Profile</label>
                                    <input type="file" class="form-control" name="teacher_image" id="teacher_image" aria-describedby="helpId">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <?= isset($teacher['teacher_image']) ? "<img class='img-thumbnail' src='/uploads/images/$teacher[teacher_image]' style='max-width:200px'>" : '' ?>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-5">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>