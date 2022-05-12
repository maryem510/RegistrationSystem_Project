<?php
include '../core/functions.php';
include '../inc/header.php';
include '../core/validations.php';
$errors = [];


foreach ($_POST as $key => $value) {
    $$key = sanitizeInput($value);
}
//validations

// email
if (!requiredVal($email)) {
    $errors[] = "email is required";
} elseif (!emailVal($email)) {
    $errors[] = "please type a valid email";
}

// password
if (!requiredVal($password)) {
    $errors[] = "password is required";
} elseif (!minVal($password, 3)) {
    $errors[] = "password must be greater than 6 chars";
} elseif (!maxVal($password, 25)) {
    $errors[] = "password must be smaller than 20 chars";
}

if (empty($errors)) {
    $_SESSION['success'] = "perfect";
    $_SESSION['auth'] = [

        'email' => $email,
        'password' => sha1($password)

    ];
    $users_file = fopen("data/users.csv", "a+");
    while ($val = fgetcsv($users_file)) {
        if ($val[1] == $email && $val[2] == sha1($password)) {
            $_SESSION['auth']['name'] = $val[0];
            $_SESSION['auth']['email'] = $email;
            $check = 1;
            break;
        }
    }

    fclose($users_file);

    if ($check) {
        header("location:../home.php");
        die();
    } else {

        $_SESSION['errors'] = ['email or password are not correct'];
        header("location:../login.php");
        die();
    }
} else {
    $_SESSION['errors'] = $errors;
    unset($_SESSION['success']);
    header("location:../login.php");
    die;
}
