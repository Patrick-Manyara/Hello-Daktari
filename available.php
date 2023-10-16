<?php
$page = 'home';
include_once 'header.php';
$categories     = get_dropdown_data(get_all('doc_category'), 'doc_category_name', 'doc_category_id');

if (isset($_SESSION['user_login'])) {
    $user = get_by_id('user', $_SESSION['user_id']);
    if (!empty($user['doctor_id'])) {
        $has_doc = true;
        $doctor = get_by_id('doctor', $user['doctor_id']);
        $action = model_url . 'session_repeat';
    } else {
        $has_doc = false;
        $action = model_url . 'session_auto';
    }
}

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
                            <form method='post' action="<?= model_url ?>user_login&page=<?= encrypt(base_url . 'available') ?>">
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
                                            <p>Dont have an account?<a href="register?type=available">Sign Up</a>
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
                            <form method="POST" enctype="multipart/form-data" action="<?= $action ?>">
                                <div class="row Margins">

                                    <?php
                                    if ($has_doc) { ?>
                                        <input hidden name="doctor_id" value="<?= $doctor['doctor_id'] ?>" />
                                        <p>Your assigned doctor is: <b><?= $doctor['doctor_name'] ?></b> </p>
                                    <?php
                                    }
                                    ?>


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


                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <?= input_hybrid('Date', 'date_date', $row, false, 'date'); ?>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <?= input_hybrid('Time', 'time_date', $row, false, 'time'); ?>
                                    </div>

                                    <div class="col-12">
                                        <h3 class="AitchOneLight" style="margin: 1em;">
                                            Type of visit
                                        </h3>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="home">
                                        <div class="VisitCard">
                                            <i class="fa-solid fa-house"></i>
                                            <p style="font-size:0.8em;">House Visit</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="online">
                                        <div class="VisitCard">
                                            <i class="fa-solid fa-video"></i>
                                            <p>Online</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="physical">
                                        <div class="VisitCard">
                                            <i class="fa-regular fa-hospital"></i>
                                            <p>Physical</p>
                                        </div>
                                    </div>

                                    <input hidden name="session_visit" id="session_visit" value="" />

                                    <div class="col-12">
                                        <h3 class="AitchOneLight" style="margin: 1em;">
                                            Channel
                                        </h3>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="audio">
                                        <div class="VisitCard2">
                                            <i class="fa-solid fa-headphones"></i>
                                            <p>Audio</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="video">
                                        <div class="VisitCard2">
                                            <i class="fa-solid fa-video"></i>
                                            <p>Video</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12" id="message">
                                        <div class="VisitCard2">
                                            <i class="fa-regular fa-comment"></i>
                                            <p>Message</p>
                                        </div>
                                    </div>

                                    <input hidden id="session_channel" name="session_channel" value="" />



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
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const visitCards = document.querySelectorAll(".VisitCard");

        visitCards.forEach(card => {
            card.addEventListener("click", function() {
                const groupId = this.parentElement.id;
                const sessionInput = groupId === "home" || groupId === "online" || groupId === "physical" ? "session_visit" : "session_channel";
                console.log(groupId);
                // Reset the previously clicked card
                visitCards.forEach(card => {
                    card.classList.remove("clicked");
                });

                // Set the new clicked card
                this.classList.add("clicked");

                // Update the session input value
                // document.getElementById(sessionInput).value = groupId;
                $('#session_visit').val(groupId);
            });
        });

        const visitCards2 = document.querySelectorAll(".VisitCard2");

        visitCards2.forEach(card2 => {
            card2.addEventListener("click", function() {
                const groupId = this.parentElement.id;
                const sessionInput = groupId === "home" || groupId === "online" || groupId === "physical" ? "session_visit" : "session_channel";
                console.log(groupId);
                // Reset the previously clicked card2
                visitCards2.forEach(card2 => {
                    card2.classList.remove("clicked");
                });

                // Set the new clicked card2
                this.classList.add("clicked");

                // Update the session input value
                document.getElementById(sessionInput).value = groupId;
                $('#session_channel').val(groupId);
            });
        });
    });

    function fileUploaded(inputId) {
        var inputFile = document.getElementById(inputId);
        inputFile.addEventListener('change', function() {
            if (inputFile.files.length > 0) {
                alert('File uploaded successfully!');
            }
        });
    }
</script>

<?php
include_once 'footer.php';
?>