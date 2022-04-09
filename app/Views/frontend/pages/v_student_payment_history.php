<?= $this->extend('frontend/template'); ?>

<?= $this->section('content'); ?>

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">History</span>
                    <h1 class="text-capitalize mb-5 text-lg">Payment History</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="appoinment section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Discuss Status</th>
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
                                echo "<td>";
                                if ($value['status_code'] == 200) {
                                    echo "<a href='/student/payment/finish?id=$value[transaction_id]' class='btn btn-info btn-sm'>Receipt</a>";
                                    if ($today < expired($value['discuss_date'], $value['quantity'])) {
                                        echo "<a href='/student/discuss?trans_id=$value[transaction_id]' class='btn btn-success btn-sm ml-1'>Discuss</a>";
                                    }
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

</section>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<script>
    $(document).ready(function() {

        setInterval(() => {
            checkStatus();
        }, 5000);
    });


    function checkStatus() {

        $.ajax({
            type: "get",
            url: "/student/payment/status",
            dataType: "json",
            success: function(response) {

                if (response.success) {

                }
            }
        });
    }
</script>

<?= $this->endSection() ?>