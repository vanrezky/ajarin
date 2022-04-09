<?= $this->extend('frontend/template'); ?>

<?= $this->section('content'); ?>

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Payment</span>
                    <h1 class="text-capitalize mb-5 text-lg">Payment Method</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="appoinment section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="mt-3">
                    <div class="feature-icon mb-3">
                        <i class="icofont-support text-lg"></i>
                    </div>
                    <span class="h3">Call for an Emergency Service!</span>
                    <h2 class="text-color mt-3">62-811-966-4647 </h2>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="appoinment-wrap mt-5 mt-lg-0 pl-lg-5">
                    <h2 class="mb-2 title-color">Order before discussing</h2>
                    <p class="mb-4">Before discussing with <b><?= $teacher['teacher_name'] ?></b>, please specify the duration of the discussion and make payments.</p>
                    <!-- form response from API Midtrans-->
                    <form id="token-form" method="post" action="">
                        <input type="hidden" name="id" value="<?= $teacher['teacher_id']; ?>">
                        <input type="hidden" name="encrypt_id" value="<?= $teacherEncryptID; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="discuss_homebase" id="discuss_homebase" class="form-control">
                                        <option value="">Choose a subject..</option>
                                        <?php
                                        $homebase = json_decode($teacher['teacher_homebase'], true);

                                        foreach ($homebase as $key => $value) {
                                            $base = teacher_homebase($value);
                                            echo "<option value='$value'>$base</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="quantity" id="quantity" type="number" class="form-control" placeholder="Order quantity">
                                </div>
                            </div>


                        </div>
                    </form>
                    <form id="payment-form" method="post" action="">
                        <input type="hidden" name="result_type" id="result-type" value="">
                        <input type="hidden" name="result_data" id="result-data" value="">
                    </form>


                    <!-- end form response from API Midtrans -->
                    <a class="btn btn-main btn-round-full" href="javascript:void(0);" id="pay-button">Pay! <i class="icofont-simple-right ml-2"></i></a>
                    <!-- <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> -->
                </div>
            </div>
        </div>
    </div>

</section>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $idMerchant; ?>"></script>
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $idMerchant; ?>"></script> -->
<script type="text/javascript">
    var resultType = document.getElementById('result-type');
    var resultData = document.getElementById('result-data');


    $(document).ready(function() {
        $("#pay-button").click(function(e) {
            e.preventDefault();
            let btn = $(this);
            let qty = $("#quantity").val();
            let base = $("#discuss_homebase").val();

            if (qty == "") {
                alert("Please enter the order quantity first");
                return false;
            }
            if (base == "") {
                alert("Please choose a subject first");
                return false;
            }

            if (confirm('you will reserve ' + (qty * 30) + ' minutes of discussion time, continue?')) {
                btn.find('i').removeClass().addClass('fa fa-spinner fa-spin ml-2');

                $.ajax({
                    type: "post",
                    url: '/student/payment/token',
                    data: $("#token-form").serializeArray(),
                    dataType: "json",
                    success: function(response) {

                        if (response.success) {

                            

                            // SnapToken acquired from previous step
                            snap.pay(response.token, {
                                // Optional
                                onSuccess: function(result) {
                                    changeResult('success', result);
                                    console.log(result.status_message);
                                    console.log(result);
                                    $("#payment-form").submit();
                                },
                                onPending: function(result) {
                                    changeResult('pending', result);
                                    console.log(result.status_message);
                                    $("#payment-form").submit();
                                },
                                onError: function(result) {
                                    changeResult('error', result);
                                    console.log(result.status_message);
                                    $("#payment-form").submit();
                                },
                                onClose: function() {
                                    btn.find('i').removeClass().addClass('icofont-simple-right ml-2');
                                    console.log('customer closed the popup without finishing the payment');
                                }
                            });
                        }

                    }
                });
            }

        });
    });

    function changeResult(type, data) {
        $("#result-type").val(type);
        $("#result-data").val(JSON.stringify(data));
        //resultType.innerHTML = type;
        //resultData.innerHTML = JSON.stringify(data);
    }
</script>
<?= $this->endSection(); ?>