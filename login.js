var link1 = document.getElementById("toReg");
var link2 = document.getElementById("toLog");
var logform = document.getElementById("loginForm");
var regform = document.getElementById("RegForm");

//for login usage
const form = document.querySelector("#loginForm form"),
loginbttn = form.querySelector(".button"),
errorText = form.querySelector(".errortext"),
emailinput = form.querySelector("#email"),
pwinput = form.querySelector("#password")





//switch to reg form
function hreftoReg(event){

    event.preventDefault(); // Prevents the default action
    logform.classList.add("switch");
    regform.classList.remove("switch");
    regform.classList.add("FormDisplay");

    let emailinputReg = document.getElementById("Regemail");
    let pwinputReg = document.getElementById("Regpassword");
    let confirmPw = document.getElementById("confirm");
    //emailinputReg.addEventListener("focusout",checkemailReg)

    
    //for reg usage
    const RegisterCheck = document.querySelector("#RegForm form"),
    Regbttn = RegisterCheck.querySelector(".button"),
    RegErrorText = RegisterCheck.querySelector(".errorText")

   function checkemailReg(){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if (data == "success"){

              }else{
                RegErrorText.textContent = data;
                RegErrorText.style.display = "block";
              }
          }
        }
    }
    let formData2 = new FormData(RegisterCheck);
    xhr.send(formData2);
    }

    function checkValidRegEmail(){
      if (emailinputReg.validity.patternMismatch){
        RegErrorText.textContent = "Please enter a valid HKU @connect email address";
        RegErrorText.style.display = "block";
      }else{
        RegErrorText.textContent ="";
        checkemailReg();
      }
    }



    function checkValidReg(event){
      if (emailinputReg.value == ''){
        event.preventDefault()
        RegErrorText.textContent = "Missing Email address!!";
        RegErrorText.style.display = "block";
      }
      if (pwinputReg.value == ''){
        event.preventDefault()
        RegErrorText.textContent = "Please provide the password";
        RegErrorText.style.display = "block";
      }
      if (confirmPw.value == ''){
        event.preventDefault()
        RegErrorText.textContent = "Please provide the confirm password!!";
        RegErrorText.style.display = "block";
      }
      
      if (pwinputReg.value != '' && confirmPw.value != '' && pwinputReg.value != confirmPw.value){
        event.preventDefault()
        RegErrorText.textContent = "Mismatch Passwords!!";
        RegErrorText.style.display = "block";
      }

      else{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  let data = xhr.response;
                  if(data === "success"){
                  }else{
                    RegErrorText.style.display = "block";
                    RegErrorText.textContent = data;
                  }
              }
          }
        }
      }
    }
    emailinputReg.addEventListener("focusout",checkValidRegEmail)
    Regbttn.addEventListener("click",checkValidReg)

}


//switch to login form
function hreftoLogin(event){


    event.preventDefault(); // Prevents the default action
    regform.classList.add("switch");
    logform.classList.remove("switch");
}


link1.addEventListener('click',hreftoReg)
link2.addEventListener('click',hreftoLogin)

function checkemailLog(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if (data == "success"){

              }else{
                errorText.textContent = data;
                errorText.style.display = "block";
              }
          }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

function checkValidEmail(){
  if (emailinput.validity.patternMismatch){
    errorText.textContent = "Please enter a valid HKU @connect email address";
    errorText.style.display = "block";
  }else{
    errorText.textContent ="";
    checkemailLog();
  }
}

function checkValidForm(event){
  if (emailinput.value == ''){
    event.preventDefault()
    errorText.textContent = "Missing Email address";
    errorText.style.display = "block";
  }
  if (pwinput.value == ''){
    event.preventDefault()
    errorText.textContent = "Please provide the password";
    errorText.style.display = "block";
  }
  else{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;

              if(data === "success"){
                location.href = "chat.php";

              }else{
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
  }
}


emailinput.addEventListener("focusout",checkValidEmail)
loginbttn.addEventListener("click",checkValidForm)
//emailinput.addEventListener("focusout",checkemailLog)