<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$data = array(
        'login_name' => $_SESSION['user_name']
    );
echo json_encode($data);
?>
