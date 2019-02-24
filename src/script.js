// SCRIPT PRINCIPALE CHE FORNISCE UN SACCO DI BELLE FUNZIONI UTILI

var headerSize; //size of the top header
var menuSize;   //size of the left menu
var buttonSize; //size of the clickable button
var left;       //actual left menu element, used to retrive the menuSize
var rect;       //rettangolo che anima il bottone per il menu
var list;       //lista delle opzioni
var shadow;     //div che oscura il contenuto

var timer;
var open = false;

window.onload = init;
function init() {
  $(()=>{
    $("title").html("Tommaso Morganti | " + pageName);
    // $('.flexslider').flexslider({ animation: slide })
    shadow = document.getElementById('contentShadow').style
    $("#header").load("/elements/header.php", ()=>{
      headerSize = document.getElementById('header').clientHeight // Retrieve header size for math
      buttonSize = document.getElementById('button').clientHeight
      rect = document.getElementById('rect').style
      $("#pageTitle").html(pageName);
    });
    $("#left").load("/elements/left.html", ()=>{
      list = document.getElementById('menuList').style
      left = document.getElementById('left'); //Retrieve leftMenu size for math
      menuSize = left.clientWidth;
      var pth = window.location.pathname;
      pth = pth.substr(1, pth.length);
      $('#source').attr('onclick', 'loadPage("/etc/print.php?url=' + pth + '")');
      left.style.left = '-' + menuSize + 'px';
    });
  });
}

function toggleMenu() {
  if (open) {
    //Se il menù è aperto, si chiude
    closeLeft();
  } else {
    //Se il menù è chiuso, si apre
    openLeft();
  }
}

function closeLeft() {
  clearTimeout(timer);  //per evitare inconvenienti bug di asincronia, grazie javascript

  timer = setTimeout(() => {
    //200 millisecondi dopo
    rect.setProperty('--move', '0px');
    shadow.display = 'none';
  }, 200)

  rect.setProperty('--rotateLeft', '0deg');
  rect.setProperty('--rotateRight', '0deg');
  list.opacity = '0';
  shadow.opacity = '0';
  left.style.left = '-' + menuSize + 'px';
  open = false;
}

function openLeft() {
  clearTimeout(timer);  //per evitare inconvenienti bug di asincronia, grazie javascript

  timer = setTimeout(() => {
    //200 millisecondi dopo
    rect.setProperty('--rotateLeft', '45deg')
    rect.setProperty('--rotateRight', '-45deg')
    list.opacity = '1';
  }, 200)

  var mov = buttonSize * 0.16;
  mov -= (buttonSize * 0.04) / 2
  rect.setProperty('--move', mov + 'px')
  left.style.left = '0px';
  shadow.display = 'block';
  setTimeout(()=>{
    //NON HO IDEA DEL PERCHÉ ma ho dovuto mettere un delay dopo il display = block,
    //1 millisecondo basta, se no l'animazione in CSS non funzionava ed era bruttissimo
    shadow.opacity = "0.3"
  }, 1)
  open = true;
}

function loadPage(urlIn) {
  // Questa è la funzione utilizzata per caricare una pagina quando si clicca su un link
  // Infatti non avvengono mai caricamenti e si ottiene una transizione carina
  console.log(urlIn);
  closeLeft();
  $.ajax({
    url: urlIn,
    success: function (response) {
      //parsa la nuova pagina
      const parser = new DOMParser();
      response = parser.parseFromString(response, 'text/html')

      var newTitle = response.getElementById("pageName").innerHTML //otiene il titolo della pagina
      newTitle = newTitle.slice(newTitle.indexOf('"') + 1, newTitle.lastIndexOf('"'));

      //sostituisci titolo
      var title = document.getElementById('pageTitle');
      $("#pageTitle").fadeTo(200, 0, ()=>{
        pageName = newTitle;
        $("title").html("Tommaso Morganti | " + pageName);
        $("#pageTitle").html(pageName).fadeTo(200, 1);
      })

      $("#content").fadeTo(200, 0, ()=>{
        //sostituisce il contenuto della pagina
        $('#content').html(response.getElementById('content').innerHTML).fadeTo(200, 1);

        //modifica l'attributo nell'url per la pagina dell'output del codice
        var srcUrl = '';
        if (urlIn.indexOf('?') > -1) {
          srcUrl = urlIn.substr(1, urlIn.indexOf('?') - 1);
        } else {
          srcUrl = urlIn.substr(1, urlIn.length);
        }
        srcUrl = "/etc/print.php?url=" + srcUrl;
        $('#source').attr("onclick", 'loadPage("' + srcUrl + '")')

        window.history.pushState(pageName, pageName, urlIn) //cambia l'url in quello della nuova pagina
      })
    }
  });
}

function toggleLogin() {
  // Funzione necessaria nella pagina di login per mostrare switchare tra login e registrazione
  var logs = $('.loginWrapper');

  var log = logs.eq(0);
  var reg = logs.eq(1);

  if (login) {
    log.fadeOut(() => {
      reg.fadeIn()
      login = false;
    })
  } else {
    reg.fadeOut(() => {
      log.fadeIn()
      login = true;
    })
  }
}

function validatePassword() {
  pwd = document.getElementsByClassName('password');
  con = pwd[1];
  pwd = pwd[0];

  if (pwd.value != con.value) {
    con.setCustomValidity('Le password non coincidono');
  } else {
    con.setCustomValidity('');
  }
}

function checkUsername() {
  var userCheck = document.getElementById('usrchk');
  userCheck.setCustomValidity("Sto controllando la disponibilità...");
  userCheck.style.border = '1.5px solid'
  userCheck.style.borderRadius = '2px'
  userCheck.style.animation = "rainbowBorder 1s ease infinite"
  setTimeout(()=> {
    $.ajax({
      url: '/etc/checkUser.php?username=' + userCheck.value,
      success: (res) => {
        if (res == 'non esiste') {
          // console.log('Puoi usarlo!');
          userCheck.setCustomValidity('');
        } else {
          // console.log("non puoi");
          userCheck.setCustomValidity('Username già preso');
        }

        if (userCheck.checkValidity()) {
          userCheck.style.borderColor = 'hsl(120, 100%, 50%)'
          userCheck.style.animation = "none"
        } else {
          userCheck.style.borderColor = 'hsl(0, 100%, 50%)'
          userCheck.style.animation = "none"
        }
      }
    });
  }, 500);
}

// var visible = true;
// $(window).scroll(()=>{
//   //work in progress, bottone che farà tornare in cima alla pagina
//   try {
//     if ($(window).scrollTop() > ($(".sidebar").offset().top + $(".sidebar").height())) {
//       if (visible) {
//         visible = false;
//         showToTop();
//       }
//     } else{
//       if(!visible) {
//         visible = true;
//         hideToTop();
//       }
//     }
//   } catch (e) {}
// })
//
// function showToTop() {
//
// }
// function hideToTop() {
//
// }
