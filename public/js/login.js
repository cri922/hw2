function checkForm(event){
  let count = 0;
  if(emailInput.value.trim()===""){
    emailInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(passwordInput.value.trim()===""){
    passwordInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(count>0){
    event.preventDefault();
  }else{
    const spans = form.querySelectorAll("span");
    for (const span of spans) {
      if(span.textContent.trim()!==""){
        event.preventDefault();
        break;
      }
    }
  }

}

function checkpassword(){
  const password = passwordInput.value.trim();
  if(password!==""){
    if(password.length<8){
      passwordInput.parentNode.querySelector("span").textContent="Password must be a minimum of 8 characters!";
      passwordInput.value="";
    }else{
      passwordInput.value=password;
      passwordInput.parentNode.querySelector("span").textContent="";
    }
  }else{
    passwordInput.value="";
    passwordInput.parentNode.querySelector("span").textContent="This field is required!";
  }
}

function checkEmail(){
  const email = emailInput.value.trim().toLowerCase();
  if(email!==""){
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(email.match(regex)){
      emailInput.value = email;
      emailInput.parentNode.querySelector("span").textContent="";
    }else{
      emailInput.parentNode.querySelector("span").textContent="Invalid email format!";
    }
  }else{
    emailInput.value="";
    emailInput.parentNode.querySelector("span").textContent="This field is required!";
  }
}

const emailInput = document.querySelector("input[type=email]");
const passwordInput = document.querySelector("input[type=password]");
const form = document.querySelector("#login-form");
emailInput.addEventListener("blur",checkEmail);
passwordInput.addEventListener("blur",checkpassword);
form.addEventListener('submit',checkForm);