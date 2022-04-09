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
                    <a href="/admin/user" class="btn btn-warning btn-sm"> <i class="fas fa-chevron-left"></i> Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post">
                                <div class="form-group">
                                    <label for="">Fullname</label>
                                    <input type="text" class="form-control" name="admin_name" id="admin_name" aria-describedby="helpId" value="<?= isset($admin['admin_name']) ? $admin['admin_name'] : old('admin_name'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="admin_username" id="admin_username" aria-describedby="helpId" value="<?= isset($admin['admin_username']) ? $admin['admin_username'] : old('admin_username'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="admin_password" id="admin_password" aria-describedby="helpId">
                                    <?= isset($admin['admin_password']) ? "<small>leave it blank if you don't want to change the password</small>" : ''; ?>

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>