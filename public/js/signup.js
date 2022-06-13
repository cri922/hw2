function onResponse(response){
  return response.json();
}

function checkForm(event){
  let count = 0;
  if(firstNameInput.value.trim()===""){
    firstNameInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(lastNameInput.value.trim()===""){
    lastNameInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(usernameInput.value.trim()===""){
    usernameInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(emailInput.value.trim()===""){
    emailInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(passwordInput.value.trim()===""){
    passwordInput.parentNode.querySelector("span").textContent="This field is required!";
    count++
  }
  if(confirmPasswordInput.value.trim()===""){
    confirmPasswordInput.parentNode.querySelector("span").textContent="This field is required!";
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

function checkConfirmPassword(){
  const confirmPassword = confirmPasswordInput.value.trim();
  if(confirmPassword!==""){
    if(confirmPassword==passwordInput.value){
      confirmPasswordInput.value = confirmPassword;
      confirmPasswordInput.parentNode.querySelector("span").textContent="";
    }else{
      confirmPasswordInput.value = "";
      confirmPasswordInput.parentNode.querySelector("span").textContent="No matching password!";
    }
  }else{
    confirmPasswordInput.value="";
    confirmPasswordInput.parentNode.querySelector("span").textContent="This field is required!";
  }
}

function checkPassword(){
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

function onEmailJson(json){
  if(json.result===true){
    emailInput.parentNode.querySelector("span").textContent="";
  }else{
    emailInput.parentNode.querySelector("span").textContent="Email already used!";
  }
}

function checkEmail(){
  const email = emailInput.value.trim().toLowerCase();
  if(email!==""){
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(email.match(regex)){
      emailInput.value = email;
      fetch(BASE_URL+"/check/email?q="+encodeURIComponent(email)).then(onResponse).then(onEmailJson);
    }else{
      emailInput.parentNode.querySelector("span").textContent="Invalid email format!";
    }
  }else{
    emailInput.value="";
    emailInput.parentNode.querySelector("span").textContent="This field is required!";
  }
}

function onUsernameJson (json){
  if(json.result===true){
    usernameInput.parentNode.querySelector("span").textContent="";
  }else{
    usernameInput.parentNode.querySelector("span").textContent="Username not available!";
  }
}

function checkUsername(){
  const username = usernameInput.value.trim();
  if(username!==""){
    const regex = /^[A-Za-z][A-Za-z0-9_]{7,15}$/;
    if(username.match(regex)){
      usernameInput.value = username;
      fetch(BASE_URL+"/check/username?q="+encodeURIComponent(username)).then(onResponse).then(onUsernameJson);
    }else{
      usernameInput.parentNode.querySelector("span").textContent="Length(8-16).Letters,numbers and underscore!";
    }
  }else{
    usernameInput.value="";
    usernameInput.parentNode.querySelector("span").textContent="This field is required!";
  }
}

function checkName(event){
  const input = event.currentTarget;
  const name = input.value.trim();
  if(name!==""){
    input.value = name;
    input.parentNode.querySelector("span").textContent="";
  }else{
    input.value="";
    input.parentNode.querySelector("span").textContent="This field is required!";
  }
}

const firstNameInput = document.querySelector("#name-form");
const lastNameInput = document.querySelector("#surname-form");
const usernameInput = document.querySelector("#username-form");
const emailInput = document.querySelector("#email-form");
const passwordInput = document.querySelector("#password-form");
const confirmPasswordInput = document.querySelector("#repassword-form");
const form = document.querySelector("#signup-form");
firstNameInput.addEventListener("blur",checkName);
lastNameInput.addEventListener("blur",checkName);
usernameInput.addEventListener("blur",checkUsername);
emailInput.addEventListener("blur",checkEmail);
passwordInput.addEventListener("blur",checkPassword);
confirmPasswordInput.addEventListener("blur",checkConfirmPassword);
form.addEventListener("submit",checkForm);