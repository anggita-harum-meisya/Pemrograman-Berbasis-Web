<?php
session_start();

// Username & password
$USERNAME = "anggita";
$PASSWORD = "gita20";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $USERNAME && $pass === $PASSWORD) {
        $_SESSION['logged_in'] = true;
        header("Location: todo.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login To-Do List</title>
<style>
body { font-family:"Poppins",sans-serif; background: linear-gradient(135deg,#a18cd1,#fbc2eb); display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}
.login-box { background: rgba(255,255,255,0.95); padding:25px; border-radius:20px; width:350px; box-shadow:0 6px 20px rgba(0,0,0,0.1);}
h1 { text-align:center; color:#444; margin-bottom:20px;}
input, button { width:100%; padding:10px; margin:5px 0; border-radius:10px; border:2px solid #b388ff; font-size:14px;}
button { background-color:#b388ff; color:white; font-weight:bold; cursor:pointer;}
button:hover { background-color:#9575cd;}
.error { color:red; text-align:center; font-size:14px; }
</style>
</head>
<body>
<div class="login-box">
    <h1>Login</h1>
    <?php if($error) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login
