<?php
$page = 'home';
include_once 'header.php';
if ($cart_count <= 0) {
    $error['empty_checkout'] = 143;
    error_checker(base_url . 'shop');
}
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
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12">
                <div class="TitleArea">
                    <p>
                        Address > Shipping > <b>Payment</b>
                    </p>
                </div>
                <div class="ShippingArea">

                    <?php
                    if (!isset($_SESSION['user_login'])) { ?>
                        <h4 class="mb-30">Log in to checkout</h4>
                        <form method='post' action="<?= model_url ?>user_login&page=<?= encrypt(base_url . 'checkout') ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-field form-group">
                                            <label for="user_email">Your Name</label>
                                            <input type="email" name="user_email" placeholder="abc@gmail.com" id="user_email" required data-error="Please enter your email">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <!--<input class="form-control MyInput"  type="text" required name="user_email" placeholder="Your Email *" />-->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-field form-group">
                                            <label for="user_password">Your Password</label>
                                            <input type="password" name="user_password" placeholder="1234" id="user_password" required data-error="Please enter your password">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <!--<input class="form-control MyInput"  required type="password" name="user_password" placeholder="Your password *" />-->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="submit" class="template-btn">Login <i class="far fa-plus"></i></button>
                                        <div id="msgSubmit" class="hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    <?php } else {
                        $user         = get_by_id('user', $_SESSION['user_id']);
                    ?>

                        <form method="POST" action="model/update/order" id="myForm">
                            <input hidden name="orders_id" value="<?= $_GET['oid'] ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-field form-group">
                                        <label for="user_name">Your Full Name</label>
                                        <input type="text" name="user_name" placeholder="Michael M. Smith" id="user_name" value="<?= $user['user_name'] ?>" required data-error="Please enter your name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <input class="form-control MyInput" hidden name="user_id" value="<?= $_SESSION['user_id'] ?>" />

                                <div class="col-lg-12">
                                    <div class="input-field form-group">
                                        <label for="user_email">Email Address</label>
                                        <input type="email" name="user_email" placeholder="abc@gmail.com" value="<?= $user['user_email'] ?>" id="user_email" required data-error="Please enter your email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-field form-group">
                                        <label for="user_phone">Phone Number</label>
                                        <input type="text" placeholder="+012 (345) 678 99" name="user_phone" value="<?= $user['user_phone'] ?>" id="user_phone">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-30">
                                        <textarea style="width: 100%;margin: 1em 0em;" rows="5" placeholder="Additional information"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--<button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>-->


                            <div class="SingleShipping">
                                <div class="DeeJus Margins">
                                    <div>
                                        <div class="form-check JusStart">
                                            <input class="form-check-input" type="radio" value="visa" name="payment_method" id="flexRadioDefault1">
                                            <label class="form-check-label AitchOneBlack" for="flexRadioDefault1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="19" viewBox="0 0 26 19" fill="none">
                                                    <path d="M3 0.75C1.75736 0.75 0.75 1.75736 0.75 3V16C0.75 17.2426 1.75736 18.25 3 18.25H23C24.2426 18.25 25.25 17.2426 25.25 16V3C25.25 1.75736 24.2426 0.75 23 0.75H3Z" fill="white" stroke="#CAD2DB" stroke-width="0.5" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9282 7.32104C14.6954 7.23467 14.3306 7.14209 13.875 7.14209C12.714 7.14209 11.8961 7.72008 11.8891 8.54845C11.8826 9.1608 12.4731 9.50245 12.9187 9.7063C13.3761 9.91513 13.5298 10.0484 13.5277 10.2349C13.5248 10.5205 13.1624 10.6511 12.8247 10.6511C12.3544 10.6511 12.1046 10.5865 11.7187 10.4274L11.5673 10.3596L11.4023 11.3136C11.6768 11.4326 12.1843 11.5357 12.7112 11.541C13.9464 11.541 14.7482 10.9696 14.7574 10.085C14.7618 9.60025 14.4487 9.23126 13.7708 8.92716C13.3601 8.73001 13.1086 8.59841 13.1112 8.39881C13.1112 8.22165 13.3241 8.03226 13.7841 8.03226C14.1684 8.02638 14.4467 8.10916 14.6636 8.19553L14.7689 8.24468L14.9282 7.32104Z" fill="#00579F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4952 9.96717C16.5924 9.7216 16.9633 8.77584 16.9633 8.77584C16.9564 8.78719 17.0598 8.52914 17.1191 8.36913L17.1986 8.73658C17.1986 8.73658 17.4235 9.75385 17.4705 9.96717H16.4952ZM17.9441 7.22034H17.0361C16.7549 7.22034 16.5444 7.29618 16.4208 7.57374L14.6758 11.4793H15.9096C15.9096 11.4793 16.1114 10.9542 16.157 10.8389C16.2919 10.8389 17.4905 10.8407 17.6619 10.8407C17.697 10.9898 17.8048 11.4793 17.8048 11.4793H18.8951L17.9441 7.22034Z" fill="#00579F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.50973 7.21924L7.35931 10.1254L7.23677 9.53478C7.02264 8.85393 6.3554 8.11634 5.60938 7.7471L6.66127 11.4741L7.9045 11.4728L9.75436 7.21924H8.50973Z" fill="#00579F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.28864 7.21667H4.39394L4.37891 7.30533C5.85303 7.65808 6.82837 8.51062 7.23326 9.53483L6.82127 7.57645C6.75009 7.30664 6.54381 7.22606 6.28864 7.21667Z" fill="#F9A51A" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2268 7.21619L9.49219 11.478H10.6667L11.4018 7.21619H10.2268Z" fill="#00579F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 3C1 1.89543 1.89543 1 3 1H23C24.1046 1 25 1.89543 25 3V6H1V3Z" fill="#00579F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25 16C25 17.1046 24.1046 18 23 18L3 18C1.89543 18 1 17.1046 1 16V13L25 13V16Z" fill="#F9A51A" />
                                                </svg>
                                                •••• 6754
                                                -
                                                <span class="MySpan">Expires 06/2021</span>
                                            </label>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="SingleShipping">
                                <div class="DeeJus Margins">
                                    <div>
                                        <div class="form-check JusStart">
                                            <input class="form-check-input" type="radio" value="mpesa" name="payment_method" id="flexRadioDefault2">
                                            <label class="form-check-label AitchOneBlack" for="flexRadioDefault2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="9" viewBox="0 0 17 9" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.2694 0.501845C7.2694 0.435052 7.24339 0.370994 7.19709 0.323764C7.15078 0.276534 7.08798 0.25 7.0225 0.25C6.95701 0.25 6.89421 0.276534 6.84791 0.323764C6.8016 0.370994 6.77559 0.435052 6.77559 0.501845V0.972435C6.75078 0.969072 6.72578 0.967379 6.70075 0.967368H4.56084C4.24811 0.967368 3.99219 1.22837 3.99219 1.54739V7.9429C3.99219 8.26188 4.24811 8.52292 4.56084 8.52292H6.70075C7.01352 8.52292 7.2694 8.26188 7.2694 7.9429V1.54739C7.26946 1.49586 7.26272 1.44455 7.24937 1.39485C7.26264 1.36349 7.26945 1.3297 7.2694 1.29555V0.501845ZM6.97013 4.64599C6.97013 5.04891 6.64691 5.37864 6.25185 5.37864H5.0099C4.61484 5.37864 4.29162 5.04891 4.29162 4.64599V2.53953C4.29162 2.13657 4.61484 1.80688 5.0099 1.80688H6.25185C6.64691 1.80688 6.97013 2.13657 6.97013 2.53953V4.64599Z" fill="#D2E288" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77344 1.94086L9.13914 1.93542C9.63704 1.99995 9.86708 2.38003 9.84617 2.933C9.80819 3.49038 9.49834 3.76278 8.98101 3.81055L8.48527 3.8005L8.49922 5.32943H7.77344V1.94086ZM8.50691 2.2882C8.84404 2.23892 9.1028 2.3345 9.12047 2.87587C9.10929 3.35921 8.85742 3.48152 8.50691 3.45589V2.28837V2.2882Z" fill="#8DC63F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1154 1.89886L11.98 1.89478L11.9735 2.27326L11.2964 2.27019C10.9057 2.3442 10.9932 2.76939 10.9742 3.07665L11.8853 3.05924L11.8884 3.52382L11.0057 3.51426L11.0015 4.63925C11.0362 4.93093 11.1866 5.07763 11.4407 5.09463L11.9257 5.08916L12.0735 5.09247L12.0689 5.44374L11.9174 5.44966L10.9959 5.43961C10.6783 5.42866 10.4219 5.26798 10.3038 4.76854L10.2812 2.58591C10.2942 2.13845 10.5839 1.91901 11.1156 1.8989L11.1154 1.89886Z" fill="#8DC63F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2965 2.85681C12.242 2.12567 12.6414 1.96058 13.1271 1.90284C13.6955 1.86851 14.0525 2.1103 14.1222 2.72723L13.4511 2.72539C13.4086 2.41417 13.1712 2.2946 12.9541 2.44269C12.6447 2.82898 13.6106 3.50879 13.9002 3.76092C14.4009 4.16482 14.3161 5.28429 13.5449 5.49184L13.0747 5.50892C12.597 5.52037 12.3128 5.21266 12.2305 4.64216L12.9066 4.6299C12.9434 4.87349 13.0453 5.02497 13.2617 5.01402C13.5983 4.94864 13.691 4.64624 13.4515 4.26069C12.9503 3.82651 12.3567 3.41922 12.2965 2.85652V2.85681Z" fill="#8DC63F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.410156 1.78833H1.12083L1.12832 2.01345C1.55775 1.82417 1.8815 1.69042 2.22087 2.00201C2.82742 1.70983 3.2861 1.74313 3.51358 2.2854L3.54523 5.32953H2.82859V2.42585C2.77554 2.17727 2.58256 2.13478 2.34972 2.15112V5.32936H1.61657V2.42585C1.56352 2.17727 1.37058 2.13478 1.13774 2.15112V5.32936H0.410156V1.78833Z" fill="#8DC63F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5195 5.41858H15.2567V3.54877H15.8702V5.41858H16.5848V2.74742C16.5705 2.20458 16.1614 1.86439 15.5822 1.86214C14.9213 1.85618 14.5445 2.17586 14.5197 2.7169V5.41858H14.5195ZM15.2567 2.55667C15.281 2.35705 15.3446 2.27667 15.5597 2.25517C15.7778 2.26093 15.8554 2.38929 15.8702 2.58715V3.12901H15.2566V2.55667H15.2567Z" fill="#8DC63F" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.86649 3.23197C4.98936 3.52513 5.15662 3.6599 5.35926 3.66816C5.0432 3.90897 4.70131 4.0553 4.34487 4.14876C4.12104 4.13417 3.90698 4.07602 3.69922 4.01799C4.22424 3.91228 4.61573 3.65308 4.86645 3.23193L4.86649 3.23197Z" fill="#82221C" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.24425 2.47668L6.98499 2.85827L7.72573 3.23986C6.97123 4.25243 5.69891 4.27908 4.34375 4.14806C5.24973 3.92037 5.87699 3.35563 6.24425 2.47668Z" fill="#EC2127" />
                                                </svg>
                                                •••• 6754
                                                -
                                                <span class="MySpan">Expires 06/2021</span>
                                            </label>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="SingleShipping">
                                <div class="DeeJus Margins">
                                    <div>
                                        <div class="form-check JusStart">
                                            <input class="form-check-input" type="radio" value="mastercard" name="payment_method" id="flexRadioDefault3">
                                            <label class="form-check-label AitchOneBlack" for="flexRadioDefault3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="17" viewBox="0 0 24 17" fill="none">
                                                    <path d="M0.25 2C0.25 1.0335 1.0335 0.25 2 0.25H22C22.9665 0.25 23.75 1.0335 23.75 2V15C23.75 15.9665 22.9665 16.75 22 16.75H2C1.0335 16.75 0.25 15.9665 0.25 15V2Z" fill="white" stroke="#CAD2DB" stroke-width="0.5" />
                                                    <circle cx="9" cy="8.5" r="4" fill="#D0091B" />
                                                    <circle cx="15" cy="8.5" r="4" fill="#F2C57C" />
                                                </svg>
                                                •••• 6754
                                                -
                                                <span class="MySpan">Expires 06/2021</span>
                                            </label>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="MainBtn">
                                    CHECKOUT
                                </button>
                            </div>

                        </form>

                    <?php }
                    ?>

                </div>
            </div>

            <div class="col-lg-5 col-sm-12 col-12">
                <?=  order_box() ?>
            </div>
        </div>
    </div>
</section>
<!--====== Contact Info Section End ======-->

<style>
    .form-check-input {
        height: 1em;
        position: inherit;
        width: auto;
        margin: 0em 1em;
    }

    .ShippingArea {}

    .SingleShipping {
        margin: 2em 0em;
        border-radius: 2px;
        border-bottom: 1px solid #D1D1D8;
    }

    .TransInput {
        border: none;
    }

    .MySpan {
        font-size: 0.8em;
        font-style: normal;
        font-weight: 200;
    }

    .Remove {
        color: #E14B4B;
    }
</style>

<?php
include_once 'footer.php';
?>