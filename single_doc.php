<?php
$page = 'home';
include_once 'header.php';

$doctor = get_by_id('doctor',security('id','GET'));
?>

<!--====== Page Title Start ======-->
<section class="page-title-area page-title-bg" style="background-image: url(assets/img/section-bg/page-title.jpg);">
    <div class="container">
        <h1 class="page-title">&nbsp;</h1>

        <ul class="breadcrumb-nav">
            <li><a href="#">Home</a></li>
            <li><i class="fas fa-angle-right"></i></li>
            <li>Specialists</li>
        </ul>
    </div>
</section>
<!--====== Page Title End ======-->

<!--====== Contact Info Section Start ======-->
<section class="section-gap contact-top-wrappper">
    <div class="container">
        <p>
            Specialist Profile
        </p>
        <div class="DeeFlex Margins">
            <img src="<?= file_url . $doctor['doctor_image'] ?>" class="ProfileImg" />
        </div>

        <div class="DeeFlex Margins">
            <h3 class="AitchOneLight">
                <?= $doctor['doctor_name'] ?>
            </h3>
        </div>

        <div class="DeeFlex Margins">
            <p class="Details">
                <?= $doctor['doctor_qualifications'] ?>
            </p>
        </div>

        <div class="DeeFlex Margins">
            <p class="Details">
                
            </p>
        </div>

        <!--<div class="DeeFlex Margins">-->
        <!--    <div class="row">-->
        <!--        <div class="col-4">-->
        <!--            <div class="DocBox">-->
        <!--                <i class="fa-solid fa-phone"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-4">-->
        <!--            <div class="DocBox">-->
        <!--                <i class="fa-solid fa-video"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-4">-->
        <!--            <div class="DocBox">-->
        <!--                <i class="fa-regular fa-comment"></i>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="DeeFlex Margins">
            <h3 class="AitchOneLight">
                About
            </h3>
        </div>

        <div class="DeeFlex Margins">
            <p class="Details">
                <?= $doctor['doctor_bio'] ?>
            </p>
        </div>

        <div class="DeeFlex Margins">
            <a class="MainBtn" style="font-size: 0.7em;" href="rebook?tid=<?= encrypt($doctor['doctor_id']) ?>">Proceed</a>
        </div>
    </div>
</section>
<!--====== Contact Info Section End ======-->

<style>
    .ProfileImg {
        width: 15em;
        height: 15em;
        border-radius: 50%;
        object-fit: cover;
    }

    .Details {
        text-align: center;
    }

    .DocBox {
        border-radius: 8px;
        background: #F4F5F7;
        width: 3em;
        height: 3em;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .DocBox i {
        color: <?= $sec_color ?>
    }
</style>

<?php
include_once 'footer.php';
?>