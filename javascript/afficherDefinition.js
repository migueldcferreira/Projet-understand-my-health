var vocab = document.getElementsByClassName('vocabulaire');
for(let i = 0; i < vocab.length; i++) {
  vocab[i].addEventListener("click", function(e)
  {
    var def = e.children[0].innerHTML;
    alert("Bonjour");
    alert(def);
  })
}
