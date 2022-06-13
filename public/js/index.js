function onResponse(response){
  return response.json();
}

function onJson(json){
  topAnimeList = json.data;
  items = json.pagination.items.count;
}

function onButtonClickListener(event){
  const randNum = Math.floor(Math.random() * items);
    img.src = topAnimeList[randNum].images.jpg.image_url;
    title.textContent = topAnimeList[randNum].title; 
}

let items;
let topAnimeList;
//fetch("https://api.jikan.moe/v4/top/anime").then(onResponse).then(onJson);
fetch(BASE_URL+"/api/top").then(onResponse).then(onJson);
const img = document.querySelector(".cover-wrapper img");
const title = document.querySelector(".cover-wrapper h2");
const button = document.querySelector(".cover-wrapper div button")
button.addEventListener("click",onButtonClickListener);