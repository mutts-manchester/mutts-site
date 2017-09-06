<?php
require 'common.php';

// Are we POSTing with the correct fields?
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !array_key_exists('email', $_POST)
    || !array_key_exists('return', $_POST) || !array_key_exists('g-recaptcha-response', $_POST))
{
    header('HTTP/1.0 400 Bad Request');
    die ('Bad Request');
}

// Verify reCaptcha
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => '6Ld_jS8UAAAAANYPoArIBlJRpWTxH8N3fZYY2Ocx',
    'response' => $_POST["g-recaptcha-response"]
);
$options = array(
    'http' => array (
        'header' => 'Content-Type: application/x-www-form-urlencoded\r\n',
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success=json_decode($verify);

// If the user failed reCaptcha send them back
if ($captcha_success->success == false) {
    $_SESSION['message'] = 'You failed the reCaptcha';
    $_SESSION['messageClass'] = 'danger';
    header('location: ./' . $_POST['return']);
}

// Optionally specify a different list name (must use the same password!)
if (array_key_exists('list', $_POST))
    $list = $_POST['list'];

// Attempt to register the address with Mailman
try {
    $mm = new Services_Mailman($listshost, isset($list) ? $list : 'MUTTS-Announcements', $listspwd);
    $mm->subscribe($_POST['email']);
    
    $_SESSION['message'] = 'Thank you, your email has been added to the mailing list. You will receive a confirmation message shortly.';
    $_SESSION['messageClass'] = 'success';
    header('location: ./' . $_POST['return']);
} catch (Services_Mailman_Exception $e) {
    $_SESSION['message'] = 'Adding address failed, reason: ' . $e->getMessage();
    $_SESSION['messageClass'] = 'danger';
    header('location: ./' . $_POST['return']);
}
?>