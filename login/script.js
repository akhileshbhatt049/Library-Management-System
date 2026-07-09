/* ==========================
   POPUP FUNCTIONS
========================== */


function openRegisterPopup(){

    document.getElementById("registerPopup")
    .style.display="flex";

}



function closeRegisterPopup(){

    document.getElementById("registerPopup")
    .style.display="none";

}




function openForgotPopup(){

    document.getElementById("forgotPopup")
    .style.display="flex";

}




function closeForgotPopup(){

    document.getElementById("forgotPopup")
    .style.display="none";

}







/* ==========================
   REGISTER ACCOUNT
========================== */


document
.getElementById("registerForm")
.addEventListener(
"submit",
async function(e){


e.preventDefault();



let fullname =
document.getElementById("fullname").value;



let email =
document.getElementById("registerEmail").value;



let phone =
document.getElementById("registerPhone").value;



let password =
document.getElementById("registerPassword").value;



let confirm =
document.getElementById("confirmRegisterPassword").value;



let message =
document.getElementById("registerMessage");





if(password.length < 4 ||
password.length > 16){


    message.style.color="red";

    message.innerHTML=
    "Password must be 4-16 characters";

    return;

}





if(password !== confirm){


    message.style.color="red";

    message.innerHTML=
    "Passwords do not match";


    return;

}





try{


let response = await fetch(
"auth/register.php",
{

method:"POST",

headers:{

"Content-Type":"application/json"

},


body:JSON.stringify({

fullname:fullname,

email:email,

phone:phone,

password:password

})


});





let data =
await response.json();




if(data.success){


message.style.color="green";


message.innerHTML=
"Account created. Your ID: "
+data.user_id;



document
.getElementById("registerForm")
.reset();



}

else{


message.style.color="red";

message.innerHTML=data.message;


}



}

catch(error){


message.style.color="red";

message.innerHTML=
"Server connection error";


}



});
 







/* ==========================
   LOGIN
========================== */



document
.getElementById("loginForm")
.addEventListener(
"submit",
async function(e){


e.preventDefault();



let email =
document.getElementById("loginEmail").value;



let password =
document.getElementById("loginPassword").value;



let message =
document.getElementById("loginMessage");





try{


let response =
await fetch(
"auth/login.php",
{


method:"POST",


headers:{


"Content-Type":
"application/json"


},


body:JSON.stringify({


email:email,


password:password


})


});





let data =
await response.json();





if(data.success){


message.style.color="green";


message.innerHTML=
"Login successful";



// redirect example

// window.location.href="dashboard.php";



}

else{


message.style.color="red";


message.innerHTML=data.message;


}


}

catch(error){


message.style.color="red";


message.innerHTML=
"Server error";


}



});









/* ==========================
   VERIFY FORGOT PASSWORD
========================== */



async function verifyAccount(){



let email =
document.getElementById("resetEmail").value;



let phone =
document.getElementById("resetPhone").value;



let message =
document.getElementById("resetMessage");





try{


let response =
await fetch(
"auth/verify-account.php",
{


method:"POST",


headers:{


"Content-Type":
"application/json"

},



body:JSON.stringify({


email:email,


phone:phone


})


});





let data =
await response.json();





if(data.success){



document
.getElementById("verifySection")
.style.display="none";



document
.getElementById("passwordSection")
.style.display="block";



message.innerHTML="";



}

else{


message.style.color="red";


message.innerHTML=
data.message;


}



}



catch(error){


message.style.color="red";


message.innerHTML=
"Server error";


}



}









/* ==========================
   CHANGE PASSWORD
========================== */



async function updatePassword(){



let password =
document.getElementById("newPassword").value;



let confirm =
document.getElementById("confirmPassword").value;



let message =
document.getElementById("resetMessage");





if(password.length < 4 ||
password.length > 16){


message.style.color="red";


message.innerHTML=
"Password must be 4-16 characters";


return;


}





if(password !== confirm){


message.style.color="red";


message.innerHTML=
"Passwords do not match";


return;


}







try{


let response =
await fetch(
"auth/reset-password.php",
{


method:"POST",


headers:{


"Content-Type":
"application/json"

},


body:JSON.stringify({


password:password


})


});





let data =
await response.json();





if(data.success){


message.style.color="green";


message.innerHTML=
"Password changed successfully";



}

else{


message.style.color="red";


message.innerHTML=
data.message;


}



}



catch(error){


message.style.color="red";


message.innerHTML=
"Server error";


}



}