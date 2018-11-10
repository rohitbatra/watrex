<?php
session_start();
require_once('includes/functions.php');

if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    $response = array('status' => false, 'response' => 'Some error occurred.');

    switch ($operation) {

        case 'login':

            // Check for Blank Field(s)
            if (!isset($_POST['login_email']) && empty($_POST['login_email']) && !isset($_POST['login_password']) && empty($_POST['login_password'])) {
                $response = array('status' => false, 'response' => 'Email & Password is required');
                echo json_encode($response);
                die();
            }

            if (!filter_var($_POST['login_email'], FILTER_VALIDATE_EMAIL)) {
                $response = array('status' => false, 'response' => 'Please provide a valid email id');
                echo json_encode($response);
                die();
            }

            $userCheckSql = "SELECT id, CONCAT(first_name,' ',last_name) as full_name, first_name, last_name  FROM `users` WHERE `email` LIKE '" . $database->escape_value(trim(strtolower($_POST['login_email']))) . "' AND `password` LIKE '" . md5($database->escape_value(strtolower(trim($_POST['login_password'])))) . "' AND `enabled` = '1' ";
            $res = $database->query($userCheckSql);
            if ($database->affected_rows() > 0) {
                while ($row = $database->fetch_array_assoc($res)) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                }
                $response = array('status' => true, 'response' => 'Login Successful.');
            } else {
                $response = array('status' => false, 'response' => 'Invalid Credentials!');
            }

            echo json_encode($response);
            break;

    }
}
