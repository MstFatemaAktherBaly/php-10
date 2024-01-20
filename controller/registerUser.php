<?php

session_start();

include "../database/env.php";

//grap data
$firstname = $_REQUEST['fname'];
$lastname = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$confirmpassword = $_REQUEST['confirmpass'];

// var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));
// exit ();

//validation
$errors = [];

//name error
if(empty($firstname)){
    $errors['name'] = "Your Name is Required";
}

//email error
if(empty($email)){
    $errors['email'] = 'Email is Required';
} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = 'Enter Your Valid Email';
}


//password error
if(empty($password)){
    $errors['password'] = "Your Password is Required";
}elseif(strlen($password) < 8){
    $errors['password'] = "Use Greater than 8 characters";
}

//confirm password error
if(empty($confirmpassword)){
    $errors['confirmpassword'] = "Confirm Your Password";
}elseif($password != $confirmpassword){
    $errors['confirmpassword'] = 'Your password is not match';
}

//if errors found
if(count($errors) > 0){
    $_SESSION['old_data'] = $_REQUEST;
    $_SESSION['errors'] = $errors;
   header("Location: ../backend/register.php");
}else{
//register

    $encpass = password_hash($password,PASSWORD_BCRYPT);
    $query = "INSERT INTO yummy_food( firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$encpass')";
    $response = mysqli_query($conn, $query);
if($response){
    header('Location: ../backend/login.php');
}
    
}