<?php
$page = 'home';
include_once 'header.php';

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
                        <h3 class="AitchOneLight" style="margin: 1em;">
                            Welcome Back
                        </h3>
                        <div class="row Margins">
                            <form method='post' action="<?= model_url ?>user_login&page=<?= encrypt(base_url) ?>" style="width: 100%;">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group ModalFormInput">
                                        <div class="form-group ModalFormInput">
                                            <input type="email" name="user_email" class="form-control AppointmentInput" placeholder="Email" aria-label="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group ModalFormInput">
                                        <div class="form-group ModalFormInput">
                                            <input type="password" name="user_password" class="form-control AppointmentInput" placeholder="Password  " aria-label="Password    ">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="TransBtn FullWidth">
                                        Continue
                                    </button>
                                </div>
                            </form>
                        </div>
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
</style>

<?php
include_once 'footer.php';
?>