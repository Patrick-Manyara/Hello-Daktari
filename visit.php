<?php
$page = 'home';
include_once 'header.php';
$categories     = get_dropdown_data(get_all('doc_category'), 'doc_category_name', 'doc_category_id');
?>


<!--====== Why Choose Section Start ======-->
<section style="background:#FFF;" class="AppSection">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12 MaxHeight">
            <img src="assets/img/images/curve1.PNG" class="CurvedImg" />
        </div>
        <div class="col-lg-6 col-sm-12 col-12">
            <div class="DeeFlex MaxHeight">
                <div class="AppointmentCard Margins">
                    <div class="AppointmentCardInner">
                        <?php
                        if (!isset($_SESSION['user_login'])) { ?>
                            <h4 class="mb-30">Login to have your address saved to your account</h4>
                            <form method='post' action="<?= model_url ?>user_login&page=<?= encrypt(base_url . 'visit') ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-field form-group">
                                                <label for="user_email">Your Name</label>
                                                <input type="email" name="user_email" placeholder="abc@gmail.com" id="user_email" required data-error="Please enter your email">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-field form-group">
                                                <label for="user_password">Your Password</label>
                                                <input type="password" name="user_password" placeholder="1234" id="user_password" required data-error="Please enter your password">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <button type="submit" class="template-btn">Login <i class="far fa-plus"></i></button>
                                            <div id="msgSubmit" class="hidden"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <p>Dont have an account?<a href="register?type=special">Sign Up</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        <?php } else {
                            $user         = get_by_id('user', $_SESSION['user_id']);
                        ?>

                            <h3 class="AitchOneLight" style="margin: 1em;">
                                Personal Details
                            </h3>
                            <form method="POST" enctype="multipart/form-data" action="<?= model_url ?>visit">
                                <div class="row Margins">
                                    <div class="col-12" id="specialist_div">
                                        <?php
                                        input_select_array("Specialist?(optional)", "doc_category_id", $row, true, $categories);
                                        ?>
                                    </div>


                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="custom-file-upload">
                                                <input type="file" accept=".pdf, .docx, .xlsx, .xls, .csv" name="session_prescription" id="applicant_certificate" onchange="fileUploaded('applicant_certificate')" />
                                                <i class="fas fa-cloud-upload" style="color:<?= $sec_color ?>"></i> Upload Prescription
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="custom-file-upload">
                                                <input type="file" name="session_records" accept=".pdf, .docx, .xlsx, .xls, .csv" id="applicant_certificate2" onchange="fileUploaded('applicant_certificate2')" />
                                                <i class="fas fa-cloud-upload" style="color:<?= $sec_color ?>"></i> Upload Medical Records
                                            </label>
                                        </div>
                                    </div>

                                    <input hidden name="session_visit" id="session_visit" value="home" />

                                   

                                    <div class="col-12">
                                        <button type="submit" class="TransBtn FullWidth Margins">
                                            Check Availability
                                        </button>
                                    </div>

                                </div>
                            </form>
                        <?php }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Why Choose Section End ======-->

<style>
    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        width: 100%;
        margin: 10px 0em;
        height: 3em;
    }


    /* //new  */
</style>


<?php
include_once 'footer.php';
?>