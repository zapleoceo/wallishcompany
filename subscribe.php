<?php
include('config.php');

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
$email = isset($_POST['email']) ? $_POST['email'] : '';

if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $con = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $email = mysqli_real_escape_string($con, $email);
    $resus = mysqli_fetch_assoc($con->query("SELECT `customer_id` FROM `oc_customer` WHERE email='".$email."' LIMIT 1"));
    if (!empty($resus['customer_id'])) {
        $con->query("UPDATE `oc_user` SET newsletter = 1 WHERE customer_id=".$resus['customer_id']." LIMIT 1");
    } else {
        $res = mysqli_fetch_assoc($con->query("SELECT `id` FROM `subscribers` WHERE email='" . $email . "' LIMIT 1"));

        if (empty($res['id']))
            $con->query("INSERT INTO `subscribers` SET `email`='" . $email . "', `time`=" . time() . ", `ip` = '" . get_ip() . "';");
    }

    $con->close();
}

exit(json_encode(array('ok' => true)));

// echo "<script>location.href='".$redirect."'</script>";
// die();