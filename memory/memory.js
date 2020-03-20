var choose1;
var indexChoose1;
var result;
var level;

function create(difficult)
{
    clear();

    //variable for random numbers
    var random;
    //variable for div->row element
    var row;
    //variable for div->card with front and back child
    var card;
    var front;
    var back;
    //index variables
    var i;
    var j;
    var n = 0;
    //variable for cards ids
    var id;

    level = difficult/2;
    result = 0;
    choose1 = -1;
    indexChoose1 = -1;

    switch(difficult)
    {
      case 4:
        var dimension = 4;
        var nrow = 2;
        var ncolumn = 2;
        var cardClass = 'card w3-card-4 w3-half';
      break;

      case 8:
        var dimension = 8;
        var nrow = 2;
        var ncolumn = 4;
        var cardClass = 'card w3-card-4 w3-half';
      break;

      case 16:
        var dimension = 16;
        var nrow = 4;
        var ncolumn = 4;
        var cardClass = 'card w3-card-4 w3-quarter';
      break;
    }
    var used = new Array(dimension/2);
    for(i=0; i<dimension/2; i++)
      used[i] = 0;

    var img = new Array(dimension)
    for(i = 0; i<dimension; i++){
      img[i]= document.createElement("img");
      img[i].setAttribute("src","img/basic1.png");
      img[i].setAttribute("class","img w3-round w3-hover-opacity");
      img[i].setAttribute("alt","CARTA!");
    }

    var backPhotos = new Array(dimension);
    j=0;
    for(i = 0; i<dimension; i++){
      if(j==dimension/2)
        j=0;
      backPhotos[i]= document.createElement("img");
      backPhotos[i].setAttribute("src", "img/cards/card"+j+".jpg");
      backPhotos[i].setAttribute("class","img w3-round w3-hover-opacity");
      backPhotos[i].setAttribute("alt", "card"+j+".jpg");
      j++;
    }



    for(i = 0; i<nrow; i += 1)
    {
      row = document.createElement("div");
      row.setAttribute('class', 'w3-container w3-row w3-row-padding');

      for(j = 0; j<ncolumn; j += 1)
      {
          card = document.createElement("div");
          card.setAttribute('class', cardClass);

          random = Math.floor(Math.random() * dimension/2);
          while(used[random] == 2)
          {
            random = Math.floor(Math.random() * dimension/2);
          }

          used[random] ++;
          card.setAttribute('value',random);

          id = (i*10)+j;
          card.setAttribute("id", id);
          card.setAttribute("onclick", "choose("+random+","+id+")");

          back = document.createElement("div");
          back.setAttribute("class", "face back");

          if(used[random]==2)
            random += dimension/2;
          back.appendChild(backPhotos[random]);

          front = document.createElement("div");
          front.setAttribute("class", "face front");
          front.appendChild(img[n]);
          n++;

          card.appendChild(back);
          card.appendChild(front);

          row.appendChild(card);
      }
      document.getElementById('grid').appendChild(row);
    }
}


function clear()
{
  var grid = document.getElementById('grid');
  while (grid.hasChildNodes()) {
    grid.removeChild(grid.firstChild);
  }
}


function choose(choose2, indexChoose2)
{
  flip(indexChoose2);
  document.getElementById("body").classList.toggle("unclickable");
  setTimeout(function(){
    document.getElementById("body").classList.toggle("unclickable");
    if(choose1 == -1)
    {
      choose1 = choose2;
      indexChoose1 = indexChoose2;
      document.getElementById(indexChoose2).classList.toggle("unclickable");
    }
    else {
      if(choose1 == choose2)
       correct(indexChoose2);
      else
        wrong(indexChoose2);
    }
  }, 1000);


}

function correct(index)
{
  document.getElementById(index).classList.toggle("unclickable");
  choose1=-1;
  //verifica se ha vinto
  result++;
  if(level==result)
  {
    Swal.fire({
        type: 'success',
        title: 'HAI VINTO!',
        text: 'MA ALLORA SEI FORTE!',
        footer: 'NO, NON STO URLANDO!'
      })
      setTimeout(function(){clear()},4000);
  }
}

function wrong(indexChoose2)
{
  flip(indexChoose1);
  flip(indexChoose2);
  document.getElementById(indexChoose1).classList.toggle("unclickable");
  choose1=-1;
  indexChoose1 = -1;

}


function flip(index) {
    document.getElementById(index).classList.toggle("is-flipped");
}
