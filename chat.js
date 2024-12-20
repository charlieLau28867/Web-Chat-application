const MSGform = document.querySelector(".typing-area"),
inputField = MSGform.querySelector(".input-field"),
user_id = MSGform.querySelector(".incoming_id").value,
sendBtn = MSGform.querySelector("button"),
chatBox = document.querySelector(".chat-box");

var logoutbttn = document.querySelector(".logoutBttn");



MSGform.onsubmit = (e)=>{
  e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
  if(inputField.value != ""){
      sendBtn.classList.add("active");
  }else{
      sendBtn.classList.remove("active");
  }
}


chatBox.onmouseenter = ()=>{
  chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
  chatBox.classList.remove("active");
}

sendBtn.onclick = ()=>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "chatmsg.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        let data = xhr.response;
        if(xhr.status === 200){
          inputField.value = "";
          scrollToBottom();
        }
    }
  }
  let MSGformData = new FormData(MSGform);
  xhr.send(MSGformData);
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "chatmsg.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          console.log(data);
          chatBox.innerHTML = data;
          if(!chatBox.classList.contains("active")){
              scrollToBottom();
          }
        }
    }
    if(xhr.status ===401){
      window.location.href = "login.php?action=Logout";
    }
  }
  xhr.send();
}, 5000);


function logout(){
  window.location.href = "login.php?action=Logout";
}
logoutbttn.addEventListener("click",logout);

function scrollToBottom(){
  chatBox.scrollTop = chatBox.scrollHeight;
}
