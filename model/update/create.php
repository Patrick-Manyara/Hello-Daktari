<?php
require_once '../../path.php';
require_once MODEL_PATH . "operations.php";
include_once('../vendor/autoload.php');
include_once '../../meeting/create_meeting.php';


$action = (isset($_GET['action']) && $_GET['action'] != '') ? security('action', 'GET') : '';


if (!csrf_verify(security('csrf_token'))) render_warning(admin_url);
unset($_POST['csrf_token']);



foreach ($_GET as $key => $val) {
    $conn = connect();
    $_GET[$key] = mysqli_real_escape_string($conn, $_GET[$key]);
}
foreach ($_POST as $key => $val) {
    $conn = connect();
    if (!is_array($_POST[$key])) {
        $_POST[$key] = mysqli_real_escape_string($conn, $_POST[$key]);
    }
}


switch ($action) {
    case 'admin_login':
        get_user_login();
        break;
    case 'user_login':
        get_login();
        break;
    case 'doctor_login':
        get_doctor_login();
        break;
    case 'admin':
        post_admin();
        break;
    case 'register':
        post_user();
        break;
    case 'doctor':
        post_doctor();
        break;
    case 'user':
        post_client();
        break;
    case 'password':
        post_password();
        break;
    case 'doctor_password':
        post_doctor_password();
        break;
    case 'inquiry':
        post_inquiry();
        break;
    case 'address':
        post_address();
        break;
    case 'user_edit':
        post_user_edit();
        break;
    case 'transfer':
        post_transfer();
        break;
    case 'order':
        post_order();
        break;
    case 'banner':
        post_banner();
        break;
    case 'session':
        post_session();
        break;
    case 'session_auto':
        post_session_auto();
        break;
    case 'session_repeat':
        post_session_repeat();
        break;
    case 'session_update':
        post_session_update();
        break;
    case 'prescription':
        post_prescription();
        break;
    case 'payment':
        post_payment();
        break;
    case 'product':
        post_product();
        break;
    case 'category':
        post_category();
        break;
    case 'lab_payment':
        post_lab_payment();
        break;
    case 'chat':
        post_chat();
        break;
    case 'send_prescription':
        post_send_prescription();
        break;
    case 'upload':
        post_upload();
        break;
    case 'visit':
        post_visit();
        break;
    case 'simple':
        post_simple($_GET['table'], $_GET['url']);
        break;
}

function post_simple($table, $url)
{
    global $arr;
    global $error;
    global $success;
    if (isset($_GET['site'])) {
        $return_url = consult_url . $url;
    } else {
        $return_url = admin_url . $url;
    }

    for_loop();


    $param = '';
    if (isset($_SESSION['edit'])) {
        $param = "?id=" . encrypt($_SESSION['edit']);
    }

    if (!empty($error)) {
        $url = $return_url . $param;
        error_checker($url);
    }

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);

        if (!build_sql_edit($table, $arr, $id, $table . '_id')) {
            $error[$table] = 149;
            error_checker($return_url . '   ?id=' . encrypt($id));
        }

        $success[$table] = 221;
        render_success($return_url . '?id=' .  encrypt($id));
    }

    $id = $arr[$table . '_id'] = create_id($table, $table . '_id');
    //  var_dump($arr);
    //  var_dump($table);

    if (!build_sql_insert($table, $arr)) {
        $error[$table] = 150;
        error_checker($return_url);
    }

    $success[$table] = 220;
    render_success($return_url . '?id=' .  encrypt($id));
}

function post_chat()
{

    foreach ($_POST as $key => $val) {
        $_POST[$key] = security($key);
    }
    $_POST['date_created'] = date("Y-m-d H:i:s");
    build_sql_insert("messages", $_POST);
}

function post_product()
{
    global $arr;
    global $error;
    global $success;
    $return_url = admin_url . 'view_products';


    for_loop();

    if (!empty($_FILES['product_image']['name'])) $arr['product_image'] = upload('product_image');

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        if (!empty($arr['product_image'])) delete_file('product_image', 'product', 'product_id', $id);

        unset($_SESSION['edit']);

        if (!build_sql_edit('product', $arr, $id, 'product_id')) {
            $error['product'] = 133;
            // system_audit ('product', $id, 'update', 'FAILED');
            error_checker($return_url);
        }

        $success['product'] = 202;
        // system_audit ('product', $id, 'update');
        render_success($return_url);
    }

    $arr['admin_id']            = $_SESSION['admin_id'];
    $id = $arr['product_id']    = create_id('product', 'product_id');

    if (!build_sql_insert('product', $arr)) {
        $error['product'] = 139;
        // system_audit ('product', $id, 'create', 'FAILED');
        error_checker($return_url);
    }

    $success['product'] = 203;
    // system_audit ('product', $id);
    render_success($return_url);
}

function post_session_auto()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . 'single_doc?id=';

    unset($_POST['date_date']);
    unset($_POST['time_date']);

    for_loop();


    if (!empty($_FILES['session_prescription']['name'])) $arr['session_prescription']   = upload_docs('session_prescription');
    if (!empty($_FILES['session_records']['name'])) $arr['session_records']             = upload_docs('session_records');

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        if (!empty($arr['session_prescription'])) delete_file('session_prescription', 'session', 'session_id');
        if (!empty($arr['session_records'])) delete_file('session_records', 'session', 'session_id');

        unset($_SESSION['edit']);

        if (!build_sql_edit('session', $arr, $id, 'session_id')) {
            $error['session'] = 133;
            error_checker($return_url);
        }

        $success['session'] = 202;
        render_success($return_url);
    }


    $id = $arr['session_id']    = create_id('session', 'session_id');
    $arr['session_code']        = 'SESS-' . generateRandomString('5');

    $arr['client_id']           =  $_SESSION['user_id'];

    if ($arr['session_visit']   == 'online') {
        $arr['session_mode']    = 'virtual';
    }


    if (!build_sql_insert('session', $arr)) {
        $error['session'] = 139;
        error_checker($return_url);
    }

    $sql = "SELECT * FROM doctor ORDER BY RAND() LIMIT 1";
    $row = select_rows($sql)[0];

    $success['session'] = 203;
    render_success($return_url . encrypt($row['doctor_id']));
}

function post_session_repeat()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . 'rebook?tid=';

    unset($_POST['date_date']);
    unset($_POST['time_date']);

    for_loop();


    if (!empty($_FILES['session_prescription']['name'])) $arr['session_prescription']   = upload_docs('session_prescription');
    if (!empty($_FILES['session_records']['name'])) $arr['session_records']             = upload_docs('session_records');


    $id = $arr['session_id']    = create_id('session', 'session_id');
    $arr['session_code']        = 'SESS-' . generateRandomString('5');

    $arr['client_id']           =  $_SESSION['user_id'];

    if ($arr['session_visit']   == 'online') {
        $arr['session_mode']    = 'virtual';
    }


    if (!build_sql_insert('session', $arr)) {
        $error['session'] = 139;
        error_checker($return_url);
    }


    $success['session'] = 203;
    render_success($return_url . encrypt($arr['doctor_id']));
}

function post_session()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . 'doctors';
    $return_url3 = base_url . 'payment';


    for_loop();


    if (!empty($_FILES['session_prescription']['name'])) $arr['session_prescription']   = upload_docs('session_prescription');
    if (!empty($_FILES['session_records']['name'])) $arr['session_records']             = upload_docs('session_records');

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        if (!empty($arr['session_prescription'])) delete_file('session_prescription', 'session', 'session_id');
        if (!empty($arr['session_records'])) delete_file('session_records', 'session', 'session_id');

        unset($_SESSION['edit']);

        if (!build_sql_edit('session', $arr, $id, 'session_id')) {
            $error['session'] = 133;
            error_checker($return_url);
        }

        $success['session'] = 202;
        render_success($return_url);
    }


    $id = $arr['session_id']    = create_id('session', 'session_id');
    $arr['session_code']        = 'SESS-' . generateRandomString('5');

    $arr['client_id']           =  $_SESSION['user_id'];

    if ($arr['session_visit']   == 'online') {
        $arr['session_mode']    = 'virtual';
    }


    if (!build_sql_insert('session', $arr)) {
        $error['session'] = 139;
        error_checker($return_url);
    }

    $success['session'] = 203;
    render_success($return_url . "?id=" . $arr['session_id']);
}

function post_visit()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . 'address&visit';
    $return_url3 = base_url . 'payment';


    for_loop();


    if (!empty($_FILES['session_prescription']['name'])) $arr['session_prescription']   = upload_docs('session_prescription');
    if (!empty($_FILES['session_records']['name'])) $arr['session_records']             = upload_docs('session_records');

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        if (!empty($arr['session_prescription'])) delete_file('session_prescription', 'session', 'session_id');
        if (!empty($arr['session_records'])) delete_file('session_records', 'session', 'session_id');

        unset($_SESSION['edit']);

        if (!build_sql_edit('session', $arr, $id, 'session_id')) {
            $error['session'] = 133;
            error_checker($return_url);
        }

        $success['session'] = 202;
        render_success($return_url);
    }


    $id = $arr['session_id']    = create_id('session', 'session_id');
    $arr['session_code']        = 'SESS-' . generateRandomString('5');

    $arr['client_id']           =  $_SESSION['user_id'];

    if ($arr['session_visit']   == 'online') {
        $arr['session_mode']    = 'virtual';
    }


    if (!build_sql_insert('session', $arr)) {
        $error['session'] = 139;
        error_checker($return_url);
    }

    $success['session'] = 203;
    render_success($return_url . "?id=" . $arr['session_id']);
}

function post_session_update()
{
    global $arr;
    global $GOOGLE_OAUTH_URL;
    global $error;
    global $success;
    $return_url = base_url . 'payment?from=session';

    if (isset($_POST['date'])) {
        $arr['session_date'] = security('date');
        unset($_POST['date']);
    }

    if (isset($_POST['time'])) {
        $post_time                  = security('time');
        $time_array                 = explode('-', $post_time);
        $arr['session_start_time']  = trim($time_array[0]); // Trim to remove any leading/trailing whitespace
        $arr['session_end_time']    = trim($time_array[1]); // Trim to remove any leading/trailing whitespace
        unset($_POST['time']);
    }

    for_loop();

    $arr2['doctor_id'] = $arr['doctor_id'];
    build_sql_edit('user', $arr2, $_SESSION['user_id'], 'user_id');

    $sql = "SELECT * FROM session WHERE client_id = '$_SESSION[user_id]' ORDER BY session_date_created DESC ";
    $row = select_rows($sql)[0];
    $id = $row['session_id'];



    if (!build_sql_edit('session', $arr, $id, 'session_id')) {
        $error['session'] = 133;
        error_checker($return_url);
    }

    $sql = "SELECT * FROM session WHERE client_id = '$_SESSION[user_id]' ORDER BY session_date_created DESC ";
    $row = select_rows($sql)[0];

    $user       = get_by_id('user', $row['client_id']);
    $doctor     = get_by_id('doctor', $row['doctor_id']);

    if ($row['session_channel'] == 'video') {
        $uploadData["doctor"] = $doctor;
        $uploadData["user"] = $user;

        $uploadData["start"] = $row['session_start_time'];
        $uploadData["date"] = $row['session_date'];
        $uploadData["end"] = $row['session_end_time'];

        $response = addEvent($uploadData);
        // echo json_encode($response);
        // exit;
        if (isset($response["success"])) {
            $_SESSION["last_event_id"] = $response["data"]["event_id"];
            $url = base_url . 'redirect';
            header("Location:$url");
        } else {
            $error['session'] = 133;
            error_checker($return_url);
        }
    }

    $success['session'] = 202;
    render_success($return_url);
}

function post_payment()
{
    global $arr;
    global $error;
    global $success;
    global $GOOGLE_OAUTH_URL;
    $return_url = base_url . 'success';
    $login_url = base_url . 'login';
    $doc_url = base_url . 'doctor/login';


    $sql = "SELECT * FROM session WHERE client_id = '$_SESSION[user_id]' ORDER BY session_date_created DESC ";
    $row = select_rows($sql)[0];

    $arr['session_payment_method']  = security('payment_method');
    $arr['session_payment_status']  = 'paid';

    // if($row['session_channel'] == 'video'){

    // }

    if (!build_sql_edit('session', $arr, $row['session_id'], 'session_id')) {
        $error['session'] = 133;
        error_checker($return_url);
    }

    $user       = get_by_id('user', $row['client_id']);
    $doctor     = get_by_id('doctor', $row['doctor_id']);



    if ($row['session_channel'] == 'message') {
        $message    = 'The user chose to have a chat with you. At the specified <b>SESSION DATE</b> and <b>START TIME</b>';
        $message    .= 'click <a href="' . base_url . 'chat?sender_token=' . $row['doctor_id'] . '&reciever_token=' . $row['client_id'] . '"> HERE </a> ';

        $message1   = 'You chose to have a chat with the specialist. At the specified <b>SESSION DATE</b> and <b>START TIME</b>';
        $message1   .= 'click <a href="' . base_url . 'chat?reciever_token=' . $row['doctor_id'] . '&sender_token=' . $row['client_id'] . '"> HERE </a> ';
    }

    if ($row['session_channel'] == 'video') {
        $uploadData["doctor"] = $doctor;
        $uploadData["user"] = $user;

        $uploadData["start"] = $row['session_start_time'];
        $uploadData["date"] = $row['session_date'];
        $uploadData["end"] = $row['session_end_time'];

        $response = addEvent($uploadData);
        if (isset($response["success"])) {

            $_SESSION["last_event_id"] = $response["data"]["event_id"];
            $url = base_url . 'redirect';
            header("Location: $url");
        } else {
            $error['session'] = 133;
            error_checker($return_url);
        }
    } else {

        $name       = APP_NAME;
        $subject    = APP_NAME . " Sign Up";


        $body       = '<p style="font-family:Poppins, sans-serif; ">Hello, ' . $user['user_name'] . '  <br>';
        $body       .= 'Your session has been successfully logged.  <br>';
        $body       .= ' <b>CODE: </b> ' . $row['session_code'] . ' <br> ';
        $body       .= ' <b>DOCTOR: </b> ' . $doctor['doctor_name'] . ' <br> ';
        $body       .= ' <b>DATE: </b> ' . $row['session_date'] . ' <br> ';
        $body       .= ' <b>START TIME: </b> ' . $row['session_start_time'] . ' <br> ';
        $body       .= ' <b>END TIME: </b> ' . $row['session_end_time'] . ' <br> ';
        $body       .= ' <b>MODE: </b> ' . ucwords($row['session_mode']) . ' <br> ';
        $body       .= $message1;
        $body       .= '<br><br>You may log in to your account <a href="' . $login_url . '" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
        $body       .= '</p>';
        $body       .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> ' . APP_NAME . ' Management</p>';


        $body2      = '<p style="font-family:Poppins, sans-serif; ">Hello, ' . $doctor['doctor_name'] . '  <br>';
        $body2      .= 'You have a new session.  <br>';
        $body2      .= ' <b>CODE: </b> ' . $row['session_code'] . ' <br> ';
        $body2      .= ' <b>CLIENT: </b> ' . $user['user_name'] . ' <br> ';
        $body2      .= ' <b>DATE: </b> ' . $row['session_date'] . ' <br> ';
        $body2      .= ' <b>START TIME: </b> ' . $row['session_start_time'] . ' <br> ';
        $body2      .= ' <b>END TIME: </b> ' . $row['session_end_time'] . ' <br> ';
        $body2      .= ' <b>MODE: </b> ' . ucwords($row['session_mode']) . ' <br> ';
        $body2       .= $message;
        $body2      .= '<br><br>You may log in to your account <a href="' . $doc_url . '" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
        $body2      .= '</p>';
        $body2      .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> ' . APP_NAME . ' Management</p>';

        email($user['user_email'], $subject, $name, $body);
        email($doctor['doctor_email'], $subject, $name, $body2);


        $success['session'] = 203;
        render_success($return_url);
    }
}

function addEvent($data)
{

    $doctor = $data["doctor"];
    $user = $data["user"];
    $title = "Video Session Meet With Doctor " . $doctor["doctor_name"];
    $description = 'Meeting between Client ' . ucwords($user["user_name"]) . ' and Doctor ' . ucwords($doctor["doctor_name"]);
    $location = 'Virtual';


    $date = $data['date'];
    $time_from = $data['start'];
    $time_to = $data['end'];

    $values = array(
        'event_id' => create_id('events', 'event_id'),
        'user_id' => $user["user_id"],
        'title' => $title,
        'description' => $description,
        'location' => $location,
        'date' => $date,
        'time_from' => $time_from,
        'time_to' => $time_to,
        'created' => date('Y-m-d H:i:s')
    );


    $buildEvent = build_sql_insert('events', $values);


    if ($buildEvent === true) {
        return ["success" => true, "data" => $values];
    } else {
        $statusMsg = 'Something went wrong, please try again after some time.';
    }


    return $statusMsg;
}

function post_upload()
{
    global $arr;
    global $error;
    global $success;
    if (isset($_GET['d'])) {
        $return_url = doctor_url . 'patient?id=' . encrypt(security('user_id'));
    } else {
        $return_url = base_url . 'upload';
    }


    for_loop();


    if (!empty($_FILES['upload_file']['name'])) $arr['upload_file']   = upload_docs('upload_file');


    $arr['upload_id']       = create_id('upload', 'upload_id');
    $arr['upload_code']     = 'FILE-' . generateRandomString('8');

    if (!build_sql_insert('upload', $arr)) {
        $error['upload'] = 139;
        error_checker($return_url);
    }

    $success['upload'] = 203;
    render_success($return_url);
}

function post_prescription()
{
    global $arr;
    global $error;
    global $success;
    $return_url = doctor_url . 'view_prescriptions';


    // cout($_POST);

    $conn = connect();

    //PRESCRIPTION DATA

    if (isset($_POST['prescription_tests'])) {
        $_POST['prescription_tests'] = implode("|", $_POST['prescription_tests']);
    }

    $arr['prescription_id']         = create_id('prescription', 'prescription_id');
    $arr['prescription_code']       = 'HDP-' . generateRandomString('6');
    $arr['user_id']                 = security('user_id');
    $arr['prescription_tests']      = $_POST['prescription_tests'];
    $arr['doctor_id']               = $_SESSION['doctor_id'];
    $arr['prescription_allergies']  = security('prescription_allergies');
    build_sql_insert("prescription", $arr);

    //MEDICATION DATA
    foreach ($_POST['medication_name'] as $key => $value) {
        $arr2['medication_id']          = create_id('medication', 'medication_id');
        $arr2['medication_name']        = mysqli_real_escape_string($conn, $_POST['medication_name'][$key]);
        $arr2['medication_dose']        = mysqli_real_escape_string($conn, $_POST['medication_dose'][$key]);
        $arr2['medication_route']       = mysqli_real_escape_string($conn, $_POST['medication_route'][$key]);
        $arr2['medication_frequency']   = mysqli_real_escape_string($conn, $_POST['medication_frequency'][$key]);
        $arr2['medication_duration']    = mysqli_real_escape_string($conn, $_POST['medication_duration'][$key]);
        $arr2['prescription_id']        = $arr['prescription_id'];
        build_sql_insert("medication", $arr2);
    }


    $success['medication'] = 203;
    render_success($return_url);
}

function post_send_prescription()
{
    global $arr;
    global $error;
    global $success;
    $return_url = doctor_url . 'view_prescriptions';

    $id         = security('id', 'GET');

    $row        = get_by_id('prescription', $id);
    $useremail  = get_by_id('user', $row['user_id'])['user_email'];


    $name       = APP_NAME;
    $subject    = APP_NAME . " PRESCRIPTION";


    $body       = '<p style="font-family:Poppins, sans-serif; ">Hello, ' . get_by_id('user', $row['user_id'])['user_name'] . '  <br>';
    $body       .= 'You have a new prescription.  <br>';

    $body       .= ' <b>DOCTOR: </b> ' . get_by_id('doctor', $row['doctor_id'])['doctor_name'] . ' <br> ';

    $body       .= '<br><br>You may download your prescription <a href="' . pdf_uri . '?id=' . $_GET['id'] . '" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
    $body       .= '</p>';
    $body       .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> ' . APP_NAME . ' Management</p>';


    email($useremail, $subject, $name, $body);

    $success['session'] = 203;
    render_success($return_url);
}


function post_lab_payment()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . 'success';


    $arr['user_id']  = $_SESSION['user_id'];
    $arr['lab_payment_id']    = create_id('lab_payment', 'lab_payment_id');
    $arr['lab_id'] = security('lab_id');
    $arr['lab_payment_method'] = security('payment_method');


    $name       = APP_NAME;
    $subject    = APP_NAME . " Sign Up";


    $body       = '<p style="font-family:Poppins, sans-serif; ">Hello, ' . $user['user_name'] . '  <br>';
    $body       .= 'Your session has been successfully logged.  <br>';
    $body       .= ' <b>CODE: </b> ' . $row['session_code'] . ' <br> ';
    $body       .= ' <b>DOCTOR: </b> ' . $doctor['doctor_name'] . ' <br> ';
    $body       .= ' <b>DATE: </b> ' . $row['session_date'] . ' <br> ';
    $body       .= ' <b>START TIME: </b> ' . $row['session_start_time'] . ' <br> ';
    $body       .= ' <b>END TIME: </b> ' . $row['session_end_time'] . ' <br> ';
    $body       .= ' <b>MODE: </b> ' . ucwords($row['session_mode']) . ' <br> ';
    $body       .= '<br><br>You may log in to your account <a href="' . $login_url . '" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
    $body       .= '</p>';
    $body       .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> ' . APP_NAME . ' Management</p>';


    $body2      = '<p style="font-family:Poppins, sans-serif; ">Hello, ' . $doctor['doctor_name'] . '  <br>';
    $body2      .= 'You have a new session.  <br>';
    $body2      .= ' <b>CODE: </b> ' . $row['session_code'] . ' <br> ';
    $body2      .= ' <b>CLIENT: </b> ' . $user['user_name'] . ' <br> ';
    $body2      .= ' <b>DATE: </b> ' . $row['session_date'] . ' <br> ';
    $body2      .= ' <b>START TIME: </b> ' . $row['session_start_time'] . ' <br> ';
    $body2      .= ' <b>END TIME: </b> ' . $row['session_end_time'] . ' <br> ';
    $body2      .= ' <b>MODE: </b> ' . ucwords($row['session_mode']) . ' <br> ';
    $body2      .= '<br><br>You may log in to your account <a href="' . $doc_url . '" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
    $body2      .= '</p>';
    $body2      .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> ' . APP_NAME . ' Management</p>';

    // email($user['user_email'], $subject, $name, $body);
    // email($doctor['doctor_email'], $subject, $name, $body2);

    if (!build_sql_insert('lab_payment', $arr)) {
        $error['lab_payment'] = 144;
        // system_audit ('lab_payment', $id, 'create', 'FAILED');
        error_checker($return_url);
    }

    $success['lab_payment'] = 211;
    // system_audit ('lab_payment', $id);
    render_success($return_url);


    $success['session'] = 203;
    render_success($return_url);
}


function post_category()
{
    global $arr;
    global $error;
    global $success;

    $return_url = admin_url . 'view_categories';

    for_loop();

    if (!empty($_FILES['category_image']['name'])) $arr['category_image'] = upload('category_image');

    error_checker($return_url);

    if (isset($_SESSION['edit'])) {
        $id     = $_SESSION['edit'];
        if (!empty($arr['category_image'])) delete_file('category_image', 'category', 'category_id', $id);

        $edit   = build_sql_edit('category', $arr, $id, 'category_id');
        unset($_SESSION['edit']);

        if ($edit !== true) {
            $error['category'] = 104;
            // system_audit ('category', $id, 'update', 'FAILED');
            error_checker($return_url);
        }

        $success['category'] = 202;
        // system_audit ('category', $id, 'update');
        render_success($return_url);
    }

    $arr['admin_id']            = $_SESSION['admin_id'];
    $id = $arr['category_id']   = create_id('category', 'category_id');

    if (!build_sql_insert('category', $arr)) {
        $error['category'] = 144;
        // system_audit ('category', $id, 'create', 'FAILED');
        error_checker($return_url);
    }

    $success['category'] = 211;
    // system_audit ('category', $id);
    render_success($return_url);
}

function post_order()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_url . "shipping";
    $return_url2 = base_url . "checkout";

    for_loop();

    if (isset($_POST['orders_id'])) {
        $id = $_POST['orders_id'];
        unset($_POST['orders_id']);
        if (!build_sql_edit('orders', $arr, $id, 'orders_id')) {
            $error['orders'] = 132;
            error_checker($return_url2 . "?oid=" . $id);
        }

        $success['orders'] = 206;
        render_success($return_url2 . "?oid=" . $id);
    }

    $id = $arr['orders_id'] = create_id('orders', 'orders_id');

    if (!build_sql_insert('orders', $arr)) {
        $error['orders'] = 144;
        error_checker($return_url);
    }

    $success['orders'] = 211;
    render_success($return_url . "?oid=" . $id);
}

function post_banner()
{
    global $arr;
    global $error;
    global $success;
    $return_url = admin_url . "view_banners";

    if (!empty($_FILES['banner_poster']['name']))    $arr['banner_poster']   = upload('banner_poster');

    for_loop();

    if (!empty($error)) {
        error_checker($return_url);
    }


    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);

        if (!empty($arr['banner_poster']))   delete_file('banner_poster', 'banner', 'banner_id', $id);

        if (!build_sql_edit('banner', $arr, $id, 'banner_id')) {
            $error['banner'] = 132;
            error_checker($return_url);
        }

        $success['banner'] = 206;
        render_success($return_url);
    }

    $arr['banner_id'] = create_id('banner', 'banner_id');

    if (!build_sql_insert('banner', $arr)) {
        $error['banner'] = 134;
        error_checker($return_url);
    }

    $success['banner'] = 205;
    render_success($return_url);
}

function post_doctor()
{
    global $arr;
    global $error;
    global $success;
    if (isset($_GET['t'])) {
        $return_url = doctor_url . "my_profile";
    } else {
        $return_url = admin_url . "view_doctors";
    }


    if (!empty($_FILES['doctor_image']['name']))    $arr['doctor_image']   = upload('doctor_image');
    if (isset($_POST['category_id'])) {
        $_POST['category_id'] = implode("|", $_POST['category_id']);
    }

    for_loop();

    if (!empty($error)) {
        error_checker($return_url);
    }


    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);

        if (!empty($arr['doctor_image']))   delete_file('doctor_image',   'doctor', 'doctor_id');

        if (!build_sql_edit('doctor', $arr, $id, 'doctor_id')) {
            $error['view_doctors'] = 153;
            error_checker($return_url);
        }

        $success['view_doctors'] = 224;
        render_success($return_url);
    }

    $arr['doctor_id'] = create_id('doctor', 'doctor_id');
    $arr['doctor_password']   = password_hashing_hybrid_maker_checker($arr['doctor_password']);

    if (!build_sql_insert('doctor', $arr)) {
        $error['view_doctors'] = 154;
        error_checker($return_url);
    }

    $success['view_doctors'] = 225;
    render_success($return_url);
}


function post_user()
{
    global $arr;
    global $error;
    global $success;

    if (isset($_GET['payment'])) {
        $return_url = base_uri . 'payment';
    } else {
        $return_url = base_uri;
    }


    for_loop();


    $id = $arr['user_id']   = create_id('user', 'user_id');
    $arr['user_password']   = password_hashing_hybrid_maker_checker($arr['user_password']);

    if (!build_sql_insert('user', $arr)) {
        $error['user'] = 139;
        error_checker($return_url);
    }


    $name       = APP_NAME;
    $subject    = APP_NAME . " Sign Up";


    $body       = '<p style="font-family:Poppins, sans-serif; ">Welcome to ' . APP_NAME . ' ' . $arr['user_name'] . '  <br>';
    $body       .= 'We are so happy you have signed up.  <br>';
    $body       .= '<br><br>You may log in to your account <a href="https://psychx.io/login.php" style="cursor:pointer;"><b> BY CLICKING HERE </b></a>';
    $body       .= '</p>';
    $body       .= '<p style="font-family:Poppins, sans-serif; ">Yours,<br> PsychX Management</p>';

    $body2      = '<p style="font-family:Poppins, sans-serif; ">A new user has signed up to ' . APP_NAME . ' with the details: <br> <b>USERNAME: </b> ' . $arr['user_name'] . ' <br>';
    $body2      .= ' <b>EMAIL: </b> ' . $arr['user_email'] . ' <br> ';
    $body2      .= '</p>';

    email($arr['user_email'], $subject, $name, $body);
    email('psychxglobal@gmail.com', $subject, $name, $body2);

    $session_login  = array(
        'login'             => true,
        'user_email'        => $arr['user_email'],
        'user_name'         => $arr['user_name'],
        'user_id'           => $arr['user_id'],
        'success'           => array('login' => 204)
    );

    session_assignment($session_login);
    writing_system_logs("Login successful session created: [ " . json_encode($_SESSION) . ' ]');

    $success['user'] = 203;
    render_success($return_url);
}

function post_client()
{
    global $arr;
    global $error;
    global $success;

    if (isset($_GET['frontend'])) {
        if (security('confirm_password') != security('user_password')) {
            $error['view_users'] = 153;
            error_checker($return_url);
        }
        unset($_POST['confirm_password']);
        if (isset($_GET['sess'])) {
            $return_url = base_url . "address";
        } elseif (isset($_GET['app'])) {
            $return_url = base_url . "appointment";
        } elseif (isset($_GET['special'])) {
            $return_url = base_url . "specialists";
        } elseif (isset($_GET['available'])) {
            $return_url = base_url . "available";
        } else {
            $return_url = base_url;
        }
    } else {
        $return_url = admin_url . 'view_users';
    }


    if (!empty($_FILES['user_image']['name']))    $arr['user_image']   = upload('user_image');

    for_loop();

    if (!empty($error)) {
        error_checker($return_url);
    }


    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);

        if (!empty($arr['user_image']))   delete_file('user_image',   'user', 'user_id');

        if (!build_sql_edit('user', $arr, $id, 'user_id')) {
            $error['view_users'] = 153;
            error_checker($return_url);
        }

        $success['view_users'] = 224;
        render_success($return_url);
    }

    $arr['user_id'] = create_id('user', 'user_id');
    $arr['user_password']   = password_hashing_hybrid_maker_checker($arr['user_password']);

    if (!build_sql_insert('user', $arr)) {
        $error['view_users'] = 154;
        error_checker($return_url);
    }

    $subject    = APP_NAME . ' Account Creation';
    $name       = APP_NAME;
    $body       = '<p style="font-family:Poppins, sans-serif;"> ';
    $body       .= 'Hello, <b> ' . $arr['user_name'] . ' </b> <br>';
    $body       .= 'Your account has been successfully created.';
    $body       .= '<br>';
    $body       .= 'You may log in to your account in the future with these credentials';
    $body       .= '<br>';
    $body       .= '<b>EMAIL:</b> ' . $arr['user_email'] . ' <br>';
    $body       .= '<br>';
    $body       .= '<b>PASSWORD:</b> ' . security('user_password') . ' <br>';
    $body       .= '<br>';


    email($arr['user_email'], $subject, $name, $body);

    if (isset($_GET['frontend'])) {
        $session_login  = array(
            'user_login'    => true,
            'user_email'    => $email,
            'user_id'       => $arr['user_id'],
            'user_name'     => $arr['user_name'],
            'success'       => array('login' => 204),
            'user_phone'    => $arr['user_phone']
        );

        session_assignment($session_login);
    }

    $success['view_users'] = 225;
    render_success($return_url);
}


function post_user_edit()
{
    global $arr;
    global $error;
    global $success;

    $return_url = client_url . 'edit_profile';



    for_loop();

    if (!empty($_FILES['user_image']['name'])) $arr['user_image'] = upload('user_image');



    $id = $_SESSION['user_id'];
    if (!empty($arr['user_image'])) delete_file('user_image', 'user', 'user_id');

    if (!build_sql_edit('user', $arr, $id, 'user_id')) {
        $error['user'] = 133;
        error_checker($return_url);
    }

    $success['user'] = 202;
    render_success($return_url);
}

function post_bookmark()
{
    global $arr;
    global $error;
    global $success;

    $arr['doctor_id'] = $_POST['doctor_id'];

    if (isset($_SESSION['login'])) {
        $arr['user_id']     = $_SESSION['user_id'];
        $column             = 'user_id';
        $value              = $_SESSION['user_id'];
    } else {
        $arr['device_id']   =  $_COOKIE['device'];
        $column             = 'device_id';
        $value              = $arr['device_id'];
    }

    $return_url = base_uri . 'find';


    $sql = "SELECT * FROM bookmark WHERE $column = '$value' AND doctor_id = '$arr[doctor_id]' ";
    $row = select_rows($sql);

    if (empty($row)) {
        $arr['bookmark_id'] = create_id('bookmark', 'bookmark_id');

        if (!build_sql_insert('bookmark', $arr)) {
            $error['bookmark'] = 162;
            error_checker($return_url);
        }

        $success['bookmark'] = 234;
        echo 'success';
    } else {
        $row = $row[0];
        if (!delete('bookmark', 'bookmark_id',  $row['bookmark_id'])) {
            $error['delete'] = 162;
            error_checker($return_url);
        }
        $success['delete'] = 235;
        echo 'success2';
    }
}

function post_address()
{
    global $arr;
    global $error;
    global $success;

    $return_url = base_url . 'address';

    if (isset($_POST['address_id'])) {
        $id = security('address_id');
        unset($_POST['address_id']);
    }

    if (isset($_SESSION['user_login'])) {
        $arr['user_id']     = $_SESSION['user_id'];
        $column             = 'user_id';
        $value              = $_SESSION['user_id'];
        $arr['device_id']   =  $_COOKIE['device'];
    } else {
        $arr['device_id']   =  $_COOKIE['device'];
        $column             = 'device_id';
        $value              = $arr['device_id'];
    }

    for_loop();

    if ($_GET['method'] == 'remove') {
        if (!delete('address', 'address_id', $id)) {
            $error['delete'] = 162;
            error_checker($return_url);
        }
        $success['delete'] = 235;
        render_success($return_url);
    }


    if ($_GET['method'] == 'edit') {
        if (!build_sql_edit('address', $arr, $id, 'address_id')) {
            $error['address'] = 151;
            error_checker($return_url);
        }

        $success['address'] = 222;
        render_success($return_url);
    }

    if ($_GET['method'] == 'add') {


        $arr['address_id'] = create_id('address', 'address_id');

        if (!build_sql_insert('address', $arr)) {
            $error['address'] = 162;
            error_checker($return_url);
        }

        $success['address'] = 234;
        render_success($return_url);
    }
}

function post_book()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_uri . "payment";
    $failed_url = base_uri . "find";

    $arr['subscription_package']    = security('subscription_package');
    $arr['subscription_amount']     = security('subscription_amount');
    $arr['device_id']               =  $_COOKIE['device'];
    $arr['subscription_id']         = create_id('subscription', 'subscription_id');
    if (isset($_SESSION['login'])) {
        $arr['subscription_name']   =  $_SESSION['user_name'];
        $arr['subscription_email']  =  $_SESSION['user_email'];
        $arr['subscription_phone']  =  get_by_id('user', $_SESSION['user_id'])['user_phone'];
    }

    if (!build_sql_insert('subscription', $arr)) {
        $error['subscription'] = 162;
        error_checker($failed_url);
    }

    $arr2 = array();
    $arr2['doctor_id']          = security('doctor_id');
    $arr2['session_date']       = security('session_date');
    $arr2['session_start_time'] = security('session_start_time');
    $arr2['session_end_time']   = security('session_end_time');
    $arr2['device_id']          =  $_COOKIE['device'];
    $arr2['session_id']         = create_id('session', 'session_id');
    $arr2['session_code']       = 'SESS-' . generateRandomString('5');
    if (isset($_SESSION['login'])) {
        $arr2['client_id']      =  $_SESSION['user_id'];
    }

    if (!build_sql_insert('session', $arr2)) {
        $error['session'] = 162;
        error_checker($failed_url);
    }

    $success['subscription'] = 234;
    render_success($return_url);
}


function post_transfer()
{
    global $arr;
    global $error;
    global $success;
    $return_url     = admin_url . "view_users";

    $doctor_from_id = get_by_id('user', security('user_id'))['doctor_id'];

    $arr['doctor_to_id']        = security('doctor_id');
    $arr['doctor_from_id']      = $doctor_from_id;
    $arr['user_id']             = security('user_id');
    $arr['doctor_move_id']      = create_id('doctor_move', 'doctor_move_id');

    if (!build_sql_insert('doctor_move', $arr)) {
        $error['doctor_move'] = 149;
        error_checker($return_url);
    }

    $arr2 = array();
    $arr2['doctor_id'] = $arr['doctor_to_id'];
    if (!build_sql_edit('user', $arr2, security('user_id'), 'user_id')) {
        $error['doctor_move'] = 149;
        error_checker($return_url);
    }


    $success['doctor_move'] = 221;
    render_success($return_url);
}


function post_password()
{
    global $arr;
    global $error;
    global $success;
    $return_url = client_url . 'password';

    $current_password = security('current_password');
    $new_password = security('new_password');
    $confirm_password = security('confirm_password');

    // cout($_POST);

    $user = get_by_id('user', $_SESSION['user_id']);

    // if (password_hashing_hybrid_maker_checker($current_password, $user['user_password'])) {
    //     $error['user'] = 157;
    //     error_checker($return_url);
    // }

    // if (password_hashing_hybrid_maker_checker($new_password, $user['user_password'])) {
    //     $error['user'] = 156;
    //     error_checker($return_url);
    // }

    if ($new_password != $confirm_password) {
        $error['user'] = 145;
        error_checker($return_url);
    }

    $arr['user_password'] = password_hashing_hybrid_maker_checker($new_password);

    if (!build_sql_edit('user', $arr, $user['user_id'], 'user_id')) {
        $error['user'] = 160;
        error_checker($return_url);
    }

    $success['user'] = 226;
    render_success($return_url);
}

function post_doctor_password()
{
    global $arr;
    global $error;
    global $success;
    $return_url = doctor_url . 'password';

    $current_password = security('current_password');
    $new_password = security('new_password');
    $confirm_password = security('confirm_password');

    // cout($_POST);

    $doctor = get_by_id('doctor', $_SESSION['doctor_id']);

    // if (password_hashing_hybrid_maker_checker($current_password, $user['user_password'])) {
    //     $error['user'] = 157;
    //     error_checker($return_url);
    // }

    // if (password_hashing_hybrid_maker_checker($new_password, $user['user_password'])) {
    //     $error['user'] = 156;
    //     error_checker($return_url);
    // }

    if ($new_password != $confirm_password) {
        $error['doctor'] = 145;
        error_checker($return_url);
    }

    $arr['doctor_password'] = password_hashing_hybrid_maker_checker($new_password);

    if (!build_sql_edit('doctor', $arr, $doctor['doctor_id'], 'doctor_id')) {
        $error['doctor'] = 160;
        error_checker($return_url);
    }

    $success['doctor'] = 226;
    render_success($return_url);
}



function post_admin()
{
    global $arr;
    global $error;
    global $success;
    $return_url = admin_url . 'view_admins';

    for_loop();

    if (!empty($error)) {
        $url = $return_url . (isset($_SESSION['edit']) ? "?id=" . encrypt($_SESSION['edit']) : '');
        error_checker($url);
    }

    if (isset($_SESSION['edit'])) {
        $id = $_SESSION['edit'];
        unset($_SESSION['edit']);

        if (!build_sql_edit('admin', $arr, $id, 'admin_id')) {
            $error['admin'] = 141;
            error_checker($return_url . '   ?id=' . encrypt($id));
        }

        $success['admin'] = 208;
        render_success($return_url . '?id=' .  encrypt($id));
    }


    $password               = generateRandomString();
    $arr['admin_password']  = password_hashing_hybrid_maker_checker($password);
    $arr['admin_id']        = create_id('admin', 'admin_id');
    $id                     = $arr['admin_id'];

    // cout($arr);

    if (!build_sql_insert('admin', $arr)) {
        $error['admin'] = 140;
        error_checker($return_url);
    }

    $email      = $arr['admin_email'];
    $subject    = 'LUNA HEALTH Admin Addition';
    $name       = 'LUNA HEALTH';
    $body       = '<p style="font-family:Poppins, sans-serif;"> ';
    $body       .= 'Hello, <b>' . $arr['admin_name'] . '</b> <br>';
    $body       .= 'You have been successfully onboarded as a <b>' . $name . '</b> admin';
    $body       .= 'Use <b>' . $password . '</b> as the password to log into the link below <br> ';
    $body       .= 'Log in to your user dashboard here: <a href=" ' . admin_url . ' ">' . admin_url . '</a>';
    $body       .= '</p>';

    email($email, $subject, $name, $body);
    $success['admin'] = 207;
    render_success($return_url . '?id=' .  encrypt($id));
}




function post_inquiry()
{
    global $arr;
    global $error;
    global $success;
    $return_url = base_uri . 'contact?suc';

    for_loop();

    $arr['inquiry_id'] = create_id('inquiry', 'inquiry_id');

    if (!build_sql_insert('inquiry', $arr)) {
        $error['inquiry'] = 152;
        error_checker($return_url);
    }

    $email      = 'info@lunafrica.com';
    $subject    = APP_NAME . ' Inquiry';
    $name       = APP_NAME;
    $body       = '<p style="font-family:Poppins, sans-serif;"> ';
    $body       .= 'Hello, admin</b> <br>';
    $body       .= 'You have a new inquiry';
    $body       .= '<br>';
    $body       .= '<b>NAME:</b> ' . $arr['inquiry_name'] . ' <br>';
    $body       .= '<br>';
    $body       .= '<b>EMAIL:</b> ' . $arr['inquiry_email'] . ' <br>';
    $body       .= '<br>';
    $body       .= '<b>PHONE:</b> ' . $arr['inquiry_phone'] . ' <br>';
    $body       .= '<br>';
    $body       .= '<b>MESSAGE:</b> ' . $arr['inquiry_message'] . ' <br>';
    $body       .= '<br>';
    $body       .= 'Log in to your admin dashboard : <a href=" ' . admin_url . ' "> CLICK HERE </a> to respond to the request';


    email($email, $subject, $name, $body);
    $success['inquiry'] = 223;
    render_success($return_url);
}




function post_new_password()
{
    global $arr;
    global $error;
    global $success;
    $return_url = consult_url . 'profile';

    // 	$password = md5($_POST['password']);

    $arr['user_password']       = password_hashing_hybrid_maker_checker($_POST['user_password']);

    if (!build_sql_edit('user', $arr, $_SESSION['user_id'], 'user_id')) {
        $error['user'] = 153;
        error_checker($return_url . '?failed');
    }


    $subject    = APP_NAME . ' Password Change';
    $name       = APP_NAME;
    $body       = '<p style="font-family:Poppins, sans-serif;"> ';
    $body       .= 'Hello, <b> ' . $_SESSION['user_name'] . ' </b> <br>';
    $body       .= 'Your account\'s password has been successfully changed.';
    $body       .= '<br>';
    $body       .= 'You may log in to your account in the future with these new credentials';
    $body       .= '<br>';
    $body       .= '<b>EMAIL:</b> ' . $_SESSION['user_email'] . ' <br>';
    $body       .= '<br>';
    $body       .= '<b>PASSWORD:</b> ' . $_POST['user_password'] . ' <br>';
    $body       .= '<br>';


    email($_SESSION['user_email'], $subject, $name, $body);

    $success['user'] = 224;
    render_success($return_url);
}

function create_id($table, $id)
{
    $date_today = date('Ymd');

    $table_prifix = array(
        'address'           => 'ADD' . $date_today,
        'admin'             => 'ADM' . $date_today,
        'banner'            => 'BNR' . $date_today,
        'brand'             => 'BRD' . $date_today,
        'company'           => 'CMP' . $date_today,
        'category'          => 'CAT' . $date_today,
        'doctor'            => 'DOC' . $date_today,
        'doctor_move'       => 'DCM' . $date_today,
        'doc_category'      => 'DCC' . $date_today,
        'inquiry'           => 'INQ' . $date_today,
        'lab'               => 'LAB' . $date_today,
        'lab_payment'       => 'LBP' . $date_today,
        'medication'        => 'MED' . $date_today,
        'orders'            => 'ORD' . $date_today,
        'product'           => 'PRD' . $date_today,
        'product_image'     => 'IMG' . $date_today,
        'session'           => 'SES' . $date_today,
        'statistic'         => 'STT' . $date_today,
        'subcategory'       => 'SUB' . $date_today,
        'subscription'      => 'SUB' . $date_today,
        'sub_orders'        => 'SUB' . $date_today,
        'tag'               => 'TAG' . $date_today,
        'unit'              => 'UNT' . $date_today,
        'prescription'      => 'PRE' . $date_today,
        'user'              => 'USR' . $date_today,
        'upload'            => 'UPD' . $date_today,
        'voucher'           => 'VOC' . $date_today,
        'events'            => 'EVE' . $date_today
    );

    $random_str = $table_prifix[$table] . rand_str();

    $get_id     = get_ids($table, $id, $random_str);

    while ($get_id == true) {
        $random_str = $table_prifix[$table] . rand_str();
        $get_id     = get_ids($table, $id, $random_str);
    }
    return $random_str;
}

function delete_file($image, $table, $id_name)
{
    $id_value = $_SESSION['edit'];

    $sql = "select $image from $table where $id_name = '$id_value'";
    $row = select_rows($sql)[0];

    return unlink(TARGET_DIR  . 'images/' . $row[$image]);
}

function for_loop()
{
    global $arr;

    foreach ($_POST as $key => $value) {
        $arr[$key] = security($key);
    }
}
