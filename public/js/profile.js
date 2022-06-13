function onNoButtonClickListener(){
  onModalClickListener();
}

function onModalClickListener(){
  modal.classList.add("hidden");
  document.body.classList.remove("no-scroll");
}

function onTrashClickListener(){
  modal.classList.remove("hidden");
  document.body.classList.add("no-scroll");
}

function onProfileImgClickListener(){
  if(dropdown_menu.classList.contains("hidden")){
    dropdown_menu.classList.remove("hidden");
    triangle.classList.remove("hidden");
  }else{
    dropdown_menu.classList.add("hidden");
    triangle.classList.add("hidden");
  }
}

const profile = document.querySelector("#profile-img");
profile.addEventListener("click",onProfileImgClickListener);
const triangle = document.querySelector(".triangle");
const dropdown_menu = document.querySelector(".menu");
const trash = document.querySelector(".delete-wrapper img");
trash.addEventListener('click',onTrashClickListener);
const modal = document.querySelector("#modal-view");
modal.addEventListener('click',onModalClickListener);
const noButton = document.querySelector("button[data-ans='no']");
noButton.addEventListener('click',onNoButtonClickListener);