function onResponse(response){
  return response.json();
}

function manageList(id,method){
  if(method=="add"){
    likesList.push({anime_id: id}); 
  }else{
    let index;
    for (let i = 0; i < likesList.length; i++) {
      if(likesList[i].anime_id==id){
        index=i;
        break;
      }
    }
    likesList.splice(index, 1);
  }
}

function onRemoveJson(json){
  const img = document.querySelector("img[data-id='"+json.animeID+"']");
  if(json.result==="true"){
    manageList(json.animeID,'delete');
    img.src="images/add.png";
    img.dataset.like="false";
    img.addEventListener("click",onLikeClickListener);
  }
  if((div=favourites.querySelector("div[data-anime-id='"+json.animeID+"']"))!=null){
    div.remove();
  }
}

function onAddJson(json){
  const img = document.querySelector("img[data-id='"+json.animeID+"']");
  if(json.result==="true"){
    manageList(json.animeID,'add');
    img.dataset.like="true";
    img.src="images/star.png";
    img.addEventListener("click",onLikeClickListener);
    const div = document.querySelector("div[data-anime-id='"+json.animeID+"']").cloneNode(true);
    favourites.appendChild(div);
    div.querySelector("img[data-id]").addEventListener("click",onFavouriteClickListener);
  }
}

function onLikeClickListener(event){
  const img = event.currentTarget;
  img.removeEventListener("click",onLikeClickListener);
  const animeID = img.dataset.id;
  if(img.dataset.like==="true"){
    fetch(BASE_URL+"/like/remove/"+animeID).then(onResponse).then(onRemoveJson);
  }else{
    fetch(BASE_URL+"/like/add/"+animeID).then(onResponse).then(onAddJson);
  }
}


function checkLike(animeID){  
  for (const i of likesList) {
    if(i.anime_id==animeID){
      return true;
    }
  }
  return false;
}

function onSearchJson(json){
  console.log(json);
  animeContainer.innerHTML="";
  let num = json.pagination.items.count;
  num = (num>9) ? 9 : num;
  for(let i=0;i<num;i++){
    const div = document.createElement("div");
    div.classList.add("card");
    div.dataset.animeId = json.data[i].mal_id;
    const addImg= document.createElement("img");
    if(checkLike(json.data[i].mal_id)){
      addImg.src = "/images/star.png";
      addImg.dataset.like = "true";
      addImg.dataset.id = json.data[i].mal_id;
    }else{
      addImg.src = "images/add.png"
      addImg.dataset.like = "false";
      addImg.dataset.id = json.data[i].mal_id;
    }
    addImg.addEventListener("click",onLikeClickListener);
    div.appendChild(addImg);
    const cover  = document.createElement("img");
    cover.src = json.data[i].images.jpg.large_image_url;
    div.appendChild(cover);
    const h2  = document.createElement("h2");
    h2.textContent = json.data[i].title;
    div.appendChild(h2);
    const p = document.createElement("p");
    let synopsis = json.data[i].synopsis;
    if(synopsis!==null){ 
      synopsis = synopsis.substring(0,100) + "... " ;
    }
    p.textContent = synopsis;
    const link = document.createElement("a");
    link.href = BASE_URL+"/anime/"+json.data[i].mal_id;
    link.textContent="Read more!";
    p.appendChild(link);
    div.appendChild(p);
    animeContainer.appendChild(div);
  }
}

function onSearchClickListener(event){
  event.preventDefault();

  const animeInput = document.querySelector("#anime-input");
  if(animeInput.value.trim()!==""){
    const name_encoded = encodeURIComponent(animeInput.value);
    //fetch("https://api.jikan.moe/v4/anime?q="+name_encoded+"&type=tv").then(onResponse).then(onSearchJson);
    fetch(BASE_URL+"/api/search?q="+name_encoded).then(onResponse).then(onSearchJson);
  }else{
    animeContainer.innerHTML="";
  }
}

function onRemoveFavouriteJson(json){
  if(json.result==="true"){
    favourites.querySelector("div[data-anime-id='"+json.animeID+"']").remove();
    if((img=document.querySelector("img[data-id='"+json.animeID+"']"))!=null){
      img.src = "images/add.png"
      img.dataset.like = "false";
    }
    manageList(json.animeID,"delete");
  }
}

function onFavouriteClickListener(event){
  animeID = event.currentTarget.dataset.id;
  fetch(BASE_URL+"/like/remove/"+animeID).then(onResponse).then(onRemoveFavouriteJson);
}

function onFavouriteJson(json){
  console.log(json);
  const div = document.createElement("div");
  div.classList.add("card");
  div.dataset.animeId = json.data.mal_id;
  const starImg = document.createElement("img");
  starImg.src = "images/star.png";
  starImg.dataset.like = "true";
  starImg.dataset.id = json.data.mal_id;
  starImg.addEventListener("click",onFavouriteClickListener);
  div.appendChild(starImg);
  const cover  = document.createElement("img");
  cover.src = json.data.images.jpg.large_image_url;
  div.appendChild(cover);
  const h2  = document.createElement("h2");
  h2.textContent = json.data.title;
  div.appendChild(h2);
  const p = document.createElement("p");
  let synopsis = json.data.synopsis;
  synopsis = synopsis.substring(0,100) + "... " ;
  p.textContent = synopsis;
  const link = document.createElement("a");
  link.href = BASE_URL+"/anime/"+json.data.mal_id;
  link.textContent="Read more!";
  p.appendChild(link);
  div.appendChild(p);
  favourites.appendChild(div);
}

function onLikesJson(json){
  likesList = json;
  console.log(likesList);
  let num =0;
  for (const ani of likesList) {
    setTimeout(function(){
      fetch(BASE_URL+"/api/anime/"+ani.anime_id).then(onResponse).then(onFavouriteJson)
    },num);/*mi sono accorto troppo tardi del rate limiting dell'api e quindi ho dovuto applicare un timeout in modo che le richieste venissero fatte ogni 2 secondi(come richiesto dall'api nella documentazione). Credo abbia senso a questo punto salvare i dati nel DB di ogni anime aggiunto ai preferiti in modo che invece di fare una rischiesta all'api la faccia al mio database.*/
    num+=2000;
  }
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

let likesList;
const username = document.querySelector(".username").textContent.trim();
const animeContainer = document.querySelector("div.anime-container");
const form = document.querySelector("#form-anime-search");
form.addEventListener("submit",onSearchClickListener);
const favourites = document.querySelector(".favourites");
fetch(BASE_URL+"/get/likes").then(onResponse).then(onLikesJson);
const triangle = document.querySelector(".triangle");
const dropdown_menu = document.querySelector(".menu");
const profile = document.querySelector("#profile-img");
profile.addEventListener("click",onProfileImgClickListener);