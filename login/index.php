<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<!-- LOGIN CARD -->

<div class="login-container">


<h2>Login</h2>



<form id="loginForm">


<div class="input-group">

<label>Email</label>

<input 
type="email"
id="loginEmail"
placeholder="Enter your email"
required>

</div>




<div class="input-group">

<label>Password</label>

<input 
type="password"
id="loginPassword"
placeholder="Enter your password"
required>

</div>





<p class="forgot-password">

<a href="#" onclick="openForgotPopup()">
Forgot Password?
</a>

</p>





<div class="button-group">


<button 
type="submit"
class="login-btn">

Login

</button>




<button
type="button"
class="create-btn"
onclick="openRegisterPopup()">

Create Account

</button>



</div>



</form>



<p id="loginMessage"></p>


</div>





<!-- =========================
CREATE ACCOUNT POPUP
========================= -->


<div class="popup-overlay" id="registerPopup">


<div class="popup-box">



<span 
class="close-btn"
onclick="closeRegisterPopup()">

&times;

</span>



<h2>Create Account</h2>




<form id="registerForm">


<div class="input-group">

<label>Full Name</label>

<input
type="text"
id="fullname"
placeholder="Enter your full name"
required>

</div>





<div class="input-group">

<label>Email</label>

<input
type="email"
id="registerEmail"
placeholder="Enter your email"
required>

</div>





<div class="input-group">

<label>Phone</label>

<input
type="tel"
id="registerPhone"
placeholder="Enter phone number"
required>

</div>





<div class="input-group">

<label>Password</label>

<input
type="password"
id="registerPassword"
placeholder="4-16 characters"
required>

</div>





<div class="input-group">

<label>Confirm Password</label>

<input
type="password"
id="confirmRegisterPassword"
placeholder="Confirm password"
required>

</div>




<button
type="submit"
class="login-btn full-btn">

Create Account

</button>



</form>



<p id="registerMessage"></p>



</div>

</div>







<!-- =========================
FORGOT PASSWORD POPUP
========================= -->


<div class="popup-overlay" id="forgotPopup">


<div class="popup-box">



<span 
class="close-btn"
onclick="closeForgotPopup()">

&times;

</span>



<h2>Reset Password</h2>





<!-- VERIFY STEP -->

<div id="verifySection">


<p>
Verify your account first.
</p>




<div class="input-group">

<label>Email</label>

<input
type="email"
id="resetEmail"
placeholder="Enter your email">

</div>





<div class="input-group">

<label>Phone</label>

<input
type="tel"
id="resetPhone"
placeholder="Enter phone number">

</div>





<button
class="login-btn full-btn"
onclick="verifyAccount()">

Verify

</button>



</div>







<!-- CHANGE PASSWORD STEP -->


<div id="passwordSection" style="display:none;">



<div class="input-group">

<label>New Password</label>

<input
type="password"
id="newPassword"
placeholder="4-16 characters">

</div>





<div class="input-group">

<label>Confirm Password</label>

<input
type="password"
id="confirmPassword"
placeholder="Confirm password">

</div>





<button
class="login-btn full-btn"
onclick="updatePassword()">

Change Password

</button>



</div>




<p id="resetMessage"></p>




</div>

</div>







<script src="script.js"></script>


</body>

</html>