var vocab = document.getElementsByClassName('vocabulaire');
for(let i = 0; i < vocab.length; i++) {
  vocab[i].addEventListener("click", function()
  {
    alert(vocab[i].children[1].innerHTML);
  })
}
