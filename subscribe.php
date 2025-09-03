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
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Validate email
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit(json_encode(array('error' => 'Invalid email address')));
}

try {
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (!$con) {
        throw new Exception('Database connection failed');
    }

    // Check if customer exists using prepared statement
    $stmt = $con->prepare("SELECT `customer_id` FROM `oc_customer` WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $resus = $result->fetch_assoc();
    
    if (!empty($resus['customer_id'])) {
        // Update customer newsletter using prepared statement
        $stmt = $con->prepare("UPDATE `oc_user` SET newsletter = 1 WHERE customer_id=? LIMIT 1");
        $stmt->bind_param("i", $resus['customer_id']);
        $stmt->execute();
    } else {
        // Check subscribers table using prepared statement
        $stmt = $con->prepare("SELECT `id` FROM `subscribers` WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = $result->fetch_assoc();

        if (empty($res['id'])) {
            // Insert new subscriber using prepared statement
            $stmt = $con->prepare("INSERT INTO `subscribers` SET `email`=?, `time`=?, `ip`=?");
            $current_time = time();
            $stmt->bind_param("sis", $email, $current_time, get_ip());
            $stmt->execute();
        }
    }

    $stmt->close();
    $con->close();
    
    exit(json_encode(array('ok' => true)));

} catch (Exception $e) {
    error_log('Subscribe error: ' . $e->getMessage());
    http_response_code(500);
    exit(json_encode(array('error' => 'Internal server error')));
}

// echo "<script>location.href='".$redirect."'</script>";
// die();