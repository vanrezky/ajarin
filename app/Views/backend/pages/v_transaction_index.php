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
                    <h6 class="m-0 font-weight-bold text-primary">List Data Student</h6>
                    <!-- <a href="/admin/student/data" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> Add Data</a> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Discuss Status</th>
                                    <th>Student</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($trans)) {
                                    $no = 1;
                                    $today = current_timestamp();
                                    foreach ($trans as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>$no</td>";
                                        echo "<td>" . teacher_homebase($value['discuss_homebase']) . "</td>";
                                        echo "<td><a href='/student/teacher-detail?id=$value[teacher_id]' target='_blank' class='badge badge-info'>$value[teacher_name]</a></td>";
                                        echo "<td>" . ($value['duration']  * $value['quantity']) . " <small>Minutes</small></td>";
                                        echo "<td>" . number_format($value['gross_amount']) . "</td>";
                                        echo "<td>$value[transaction_status]</td>";
                                        echo "<td>" . discuss_status($value['discuss_status']) . "</td>";
                                        echo "<td><b>$value[student_name]</b><br>$value[student_email]</td>";
                                        echo "<td>";
                                        if ($value['status_code'] == 200) {
                                            echo "<a href='/admin/transaction/receipt?id=$value[transaction_id]' class='btn btn-info btn-sm'>Receipt</a>";
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>History is Empty!</td></tr>";
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