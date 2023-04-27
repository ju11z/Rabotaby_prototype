<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
$response['state']='success';
echo json_encode($response);
