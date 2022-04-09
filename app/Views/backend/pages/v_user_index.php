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
                    <h6 class="m-0 font-weight-bold text-primary">List Data Admin</h6>
                    <a href="/admin/user/data" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Add Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($admin as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>$no</td>";
                                    echo "<td>$value[admin_name]</td>";
                                    echo "<td>$value[admin_username]</td>";
                                    echo "<td>
                                        <a href='/admin/user/data/$value[admin_id]' class='btn btn-info btn-sm'>Edit</a>
                                        <a href='/admin/user/delete/$value[admin_id]' onclick='return confirm(\"Are you sure you want to delete this data?\")' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>";
                                    echo "</tr>";

                                    $no++;
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>