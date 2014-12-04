<?php
session_start();
$data = array(
        'pic' => base64_encode($_SESSION['user_pic']),
        'pic_w' => $_SESSION['pic_w'],
        'pic_h' => $_SESSION['pic_h'],
        'pic_ml' => $_SESSION['pic_ml'],  
        'pic_mt' => $_SESSION['pic_mt'],
        'user_name' => $_SESSION['user_name'],
        'user_sex' => $_SESSION['user_sex'],
        'user_birthday' => $_SESSION['user_birthday'],
        'user_school' => $_SESSION['user_school'],
        'user_department' => $_SESSION['user_department']
    );
echo json_encode($data);
?>
