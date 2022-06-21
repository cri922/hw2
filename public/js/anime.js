function onProfileImgClickListener(){
  if(dropdown_menu.classList.contains("hidden")){
    dropdown_menu.classList.remove("hidden");
    triangle.classList.remove("hidden");
  }else{
    dropdown_menu.classList.add("hidden");
    triangle.classList.add("hidden");
  }
}

function onResponse(response){
  console.log("response");
  return response.json();
}

function onCommentsJson(json){
  console.log(json);
  if(json.items>0){
    for (const comment of json.data) {
      const div = document.createElement("div");
      div.classList.add("comment-wrapper");
      const subdiv = document.createElement("div");
      subdiv.classList.add("info");
      const author = document.createElement("span");
      author.classList.add("author");
      author.textContent=comment.username;
      const date = document.createElement("span");
      date.textContent=comment.created_at.substring(0,10);
      subdiv.appendChild(author);
      subdiv.appendChild(date);
      div.appendChild(subdiv);
      const p = document.createElement("p");
      p.textContent = comment.content;
      div.appendChild(p);
      comments.appendChild(div);
    }
  }
}

function onResponse(response){
  return response.json();
}

function onAddCommentJson(json){
  if(json.result == true){
    const div = document.createElement("div");
    div.classList.add("comment-wrapper");
    const subdiv = document.createElement("div");
    subdiv.classList.add("info");
    const author = document.createElement("span");
    author.classList.add("author");
    author.textContent=username;
    const date = document.createElement("span");
    date.textContent="now";
    subdiv.appendChild(author);
    subdiv.appendChild(date);
    div.appendChild(subdiv);
    const p = document.createElement("p");
    p.textContent = textarea.value;
    div.appendChild(p);
    comments.prepend(div);
    textarea.value="";
  }else{
    textarea.value="Impossible to post the comment. Please retry...";
  }
}

function onPostCommentListener(event){
  event.preventDefault();
  const comment = textarea.value.trim();
  if(comment!=""){
    const formData = new FormData(form);
    formData.append('comment',comment);
    formData.append('_token',CSRF_TOKEN);
    fetch(BASE_URL+"/comment/add/"+title.dataset.id,{
      method: 'POST',
      body: formData,
    }).then(onResponse).then(onAddCommentJson);
  }else{
    textarea.value="";
  }
}

const username = document.querySelector(".username").textContent.trim();
const profile = document.querySelector("#profile-img");
profile.addEventListener("click",onProfileImgClickListener);
const triangle = document.querySelector(".triangle");
const dropdown_menu = document.querySelector(".menu");
const title = document.querySelector(".description-wrapper h1");
const comments = document.querySelector(".comments-content-wrapper");
fetch(BASE_URL+"/get/comments/"+title.dataset.id).then(onResponse).then(onCommentsJson);
const form = document.querySelector("#form-comment");
form.addEventListener("submit",onPostCommentListener);
const textarea = document.querySelector("#comment-textarea");
