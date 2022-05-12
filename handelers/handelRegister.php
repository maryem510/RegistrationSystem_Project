<?php
include '../core/functions.php';
include '../inc/header.php';
include '../core/validations.php';
$errors = [];

if (checkRequestMethod("POST") && checkPostInput("name")) {

    foreach ($_POST as $key => $value) {
        $$key = sanitizeInput($value);
    }
    //validations
    // name
    if (!requiredVal($name)) {
        $errors[] = "name is required";
    } elseif (!minVal($name, 3)) {
        $errors[] = "name must be greater than 3 chars";
    } elseif (!maxVal($name, 25)) {
        $errors[] = "name must be smaller than 25 chars";
    }

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
            'name' => $name,
            'email' => $email,


        ];
        $users_file = fopen("data/users.csv", "a+");
        fputcsv($users_file, [$name, $email, sha1($password)]);
        fclose($users_file);
        unset($_SESSION['errors']);
        header("location:../profile.php");
        die();
    } else {
        $_SESSION['errors'] = $errors;
        unset($_SESSION['success']);
        header("location:../register.php");
        die();
    }
}
