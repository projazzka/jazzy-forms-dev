<?php

function jzzf_send_email($email) {
    $message = $email["message"] . "\r\n\r\n";
    $headers = 'From: '. $email["from"] . "\r\n" .
    "Content-type: text/html";
    return wp_mail($email["to"], $email["subject"], $message, $headers);
}