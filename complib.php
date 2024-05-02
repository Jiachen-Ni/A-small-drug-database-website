<?php
session_start();
require_once 'login.php';
include 'header.html';

echo <<<_HEAD1
<html>
<head>
<style>
button { 
       background-color: darkslategrey; 
       width: 50%;
       color: white;
       text-align: center; 
       padding: 15px;
       display: inline-block; 
       margin: 15px 80px; 
       border: none; 
       cursor: pointer;
       font-size: 16px;
       border-radius: 10px; 
       box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
}
.login_panel {
             background-color: #d0cece;
             border-radius: 10px;
             padding: 20px;
             width: 300px;
             margin-bottom: 20px;
             margin-left:auto;
             margin-right: auto;
             box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
}
.login_panel h2 {
                text-align: center;
                margin-bottom: 30px;               
}
.login_panel input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
}
</style>
<link rel="stylesheet" href="global.css">
</head>
<body>
<div class="main-content">
        <script>
            function validate(form) {
                fail = ""
                if(form.fn.value == "") fail = "Must Give Forname "
                if(form.sn.value == "") fail += "Must Give Surname"
                if(fail == "") return true
                else {alert(fail); return false}
            }
        </script>
    <div class="login_panel">
        <h2>Login</h2>
        <form action="home.php" method="post" onSubmit="return validate(this)">
            <label> First name : </label> 
            <input type="text" placeholder="Enter First Name" name="fn">
            <label> Last name : </label> 
            <input type="text" placeholder="Enter Last Name" name="sn"/>
            <button type="submit">Login</button> 
        </form>
    </div>
_HEAD1;

echo <<<_TAIL1
</div>
</body>
</html>
_TAIL1;
include 'footerbar.html';
?>