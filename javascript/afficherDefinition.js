var vocab = getElementsByClassName('vocabulaire');
for(let i = 0; i < vocab.length; i++) {
  vocab[i].addEventListener("click", function(e)
  {
    var def = e.children[1].innerHTML;
    alert(def);
  })
}
