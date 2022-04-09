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
                    <h6 class="m-0 font-weight-bold text-primary">List Data Teacher</h6>
                    <a href="/admin/teacher/data" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Add Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Base</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Images</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($teacher as $key => $value) {

                                    $homebase = json_decode($value['teacher_homebase'], true);
                                    $hb = "";
                                    foreach ($homebase as $k => $v) {
                                        $hb .= teacher_homebase($v) . ", ";
                                    }
                                    echo "<tr>";
                                    echo "<td>$no</td>";
                                    echo "<td>$value[teacher_name]</td>";
                                    echo "<td>$hb</td>";
                                    echo "<td>$value[teacher_phonenumb]</td>";
                                    echo "<td>$value[teacher_email]</td>";
                                    echo "<td><img class='img-thumbnail' src='/uploads/images/$value[teacher_image]' style='max-width:70px'></td>";
                                    echo "<td>
                                        <a href='/admin/teacher/data/$value[teacher_id]' class='btn btn-info btn-sm'>Edit</a>
                                        <a href='/admin/teacher/delete/$value[teacher_id]' onclick='return confirm(\"Are you sure you want to delete this data?\")' class='btn btn-danger btn-sm'>Delete</a>
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