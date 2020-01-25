console.log("1");

(function(){ // Crea una función que se va a ejecutar cuando la pagina entera se cargue
  'use strict'; 
  document.addEventListener('DOMContenteLoaded', function(){
    // getElementById
    document.getElementById('logo');

    // getElementsByClassName
    document.getElementsByClassName('contenido');

    // getElementsByTag

    var enlaces = document.getElementsByTagName('a');
    console.log(enlaces);

    var enlacesSidebar = document.getElementById('siderbar').getElementsByTagName('a');
    console.log(enlacesSidebar);

    for(var i = 0; i < enlacesSidebar.length; i++){
      enlacesSidebar[i].setAttribute('href', 'https://www.google.com');
    }

    // querySelector

    var logo = document.querySelector('#logo');
    console.log(logo);

    // querySelectorAll

    var encabezado = document.querySelectorAll('h2, footer p');
    console.log(encabezado);

    // Crear contenido

    var sidebar = document.querySelector('#sidebar');
    var nuevoElemento = document.createElement("H1");
    var nuevoTexto = document.createTextNode("Hola Mundo");
    nuevoElemento.appendChild(nuevoTexto);
    sidebar.appendChild(nuevoElemento);

    // Clonar nodo

    var contenido = document.querySelectorAll('main');
    var nuevoContenido = contenido[0].cloneNode(true);

    var sidebar = document.querySelector('aside');

    sidebar.insertBefore(nuevoContenido, sidebar.childNodes[5]);

    // Eliminar nodos

    var primerPost = document.querySelector('main article');
    primerPost.parentNode.removeChild(primerPost);

    // Reemplazar nodos

    var viejoNodo = document.querySelector('main h2');
    var nuevoNodo = document.querySelector('footer h2');
    viejoNodo.parentNode.replaceChild(nuevoNodo, viejoNodo);

    // reemplazar con uno nuevo

    var nuevoTitulo = document.createElement('H2');
    var nuevoTexto = document.createTextNode('Hola Mundo');
    nuevoTitulo.appendChild(nuevoTexto);

    var viejoNodo = document.querySelector('main h2');
    viejoNodo.parentNode.replaceChild(nuevoTitulo, viejoNodo);

  });
})();

console.log("3");