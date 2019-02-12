var images = [
  "/src/images/homebg1.JPG",
  "/src/images/homebg2.JPG",
  "/src/images/homebg3.JPG"
]

var bgTimer = setTimeout(()=>{
  var homebg = document.getElementById('homebg').style;
  var rand = Math.floor(Math.random() * 3);
  homebg.backgroundImage = "url(" + images[rand] + ")";
  homebg.opacity = 1;
}, 1000);

function changeBG() {
  clearTimeout(bgTimer);
  var homebg = document.getElementById('homebg').style;
  homebg.opacity = 0;
  bgTimer = setTimeout(()=>{
    var rand = Math.floor(Math.random() * 3);
    homebg.backgroundImage = "url(" + images[rand] + ")";
    homebg.opacity = 1;
  }, 1000)
}
