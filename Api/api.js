// API key: 718818a94bb0e4accef0be9f329d9419


function recupererPrix() {

fetch("https://api.nomics.com/v1/currencies/ticker?key=718818a94bb0e4accef0be9f329d9419&ids=&interval=1d,30d&convert=USD&per-page=100&page=1")
  .then(response => response.json())
  .then(data => document.querySelector('#divPrix').textContent = "Prix du BTC : " + Math.trunc(data[0]['price']) + " $")
}


recupererPrix();
