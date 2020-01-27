(function () {
    "use strict";


    var regalo = document.getElementById('regalo');

    document.addEventListener('DOMContentLoaded', function (){

        /* Mapa */
        var map = L.map('mapa').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('GDLWebCamp 2019 <br> Boletos ya disponibles.')
            .openPopup();


        /* Campos datos usuario */
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');
        
        /* Campos pases */
        var pase_dia = document.getElementById('pase_dia');
        var pase_dos_dias = document.getElementById('pase_dos_dias');
        var pase_completo = document.getElementById('pase_completo');

        /* Botones y divs */
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        var resultado = document.getElementById('lista-productos');
        var suma = document.getElementById('suma-total');

        /* Extras */

        var camisas = document.getElementById('camisa_evento');
        var etiquetas = document.getElementById('etiquetas');

        botonRegistro.disabled = true;

        if(document.getElementById('calcular')) {

            calcular.addEventListener('click', calcularMontos);

            pase_dia.addEventListener('blur', mostrarDias);
            pase_dos_dias.addEventListener('blur', mostrarDias);
            pase_completo.addEventListener('blur', mostrarDias);

            nombre.addEventListener('blur', validarCampos);
            apellido.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarMail);



            function validarCampos(){
                if(this.value == ''){
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "Este campo es obligatorio";
                    this.style.border = "1px solid red";
                } else {
                    errorDiv.style.display = "none";
                    this.style.border = '1px solid #cccccc';
                }
            }

            function validarMail(){
                if(this.value.indexOf("@") != -1){ /* 'indexOf' busca la existencia */
                    errorDiv.style.display = "none";
                    this.style.border = '1px solid #cccccc';
                } else {
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "Debe tener al menos un @";
                    this.style.border = "1px solid red";
                }
            }

            function calcularMontos(event){
                event.preventDefault();
                if(regalo.value === ''){
                    alert("Debes elegir un regalo");
                    regalo.focus();
                } else{
                    var boletosDia = parseInt(pase_dia.value, 10) || 0,
                        boletosDosDias = parseInt(pase_dos_dias.value, 10) || 0,
                        boletoCompleto = parseInt(pase_completo.value, 10) || 0,
                        cantCamisas = parseInt(camisas.value, 10) || 0,
                        cantEtiquetas = parseInt(etiquetas.value, 10) || 0;

                    var totalPagar = (boletosDia * 30) + (boletosDosDias * 45) * (boletoCompleto * 50) + ((cantCamisas * 10) * .93) + (cantEtiquetas * 2);

                    var listadoProductos = [];

                    if(boletosDia >= 1){
                    listadoProductos.push(boletosDia + ' Pases por día');
                    }

                    if(boletosDosDias >= 1){
                        listadoProductos.push(boletosDosDias + ' Pases por dos días');
                    }

                    if(boletoCompleto >= 1){
                        listadoProductos.push(boletoCompleto + ' Pase completo');
                    }
                    
                    if(cantCamisas >= 1){
                        listadoProductos.push(cantCamisas + ' Camisas');
                    }

                    if(cantEtiquetas >= 1){
                        listadoProductos.push(cantEtiquetas + ' Etiquetas');
                    }

                    lista_productos.style.display = "block";
                    lista_productos.innerHTML = '';
                    for(var i = 0; i < listadoProductos.length; i++){
                        lista_productos.innerHTML += listadoProductos[i] + '<br/>';
                    }

                    suma.innerHTML = '$ ' + totalPagar.toFixed(2); /* El 2 indica que sólo nos devuelva dos décimos para los centavos */
                    botonRegistro.disabled = false;
                    document.getElementById('total_pedido').value = totalPagar;
                }
            }

            function mostrarDias(event){
                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletosDosDias = parseInt(pase_dos_dias.value, 10) || 0,
                    boletoCompleto = parseInt(pase_completo.value, 10) || 0;

                var diasElegidos = [];

                if(boletosDia > 0){
                    diasElegidos.push('viernes');
                }

                if(boletosDosDias > 0){
                    diasElegidos.push('viernes', 'sabado');
                }

                if(boletoCompleto > 0){
                    diasElegidos.push('viernes', 'sabado', 'domingo');
                }

                for(var i = 0; i < diasElegidos.length; i++){
                    document.getElementById(diasElegidos[i]).style.display = "block";
                }


            }
        }


    }); /* DOM CONTENT LOADED */
})();


$(function() {
    /* Lettering */
    $('.nombre-sitio').lettering();

    /* Agregar clase a menú */

    $('body.conferencia .navegacion-principal a:conteins(\'Conferencia\')').addClass('activo');
    $('body.conferencia .navegacion-principal a:conteins(\'Calendario\')').addClass('activo');
    $('body.conferencia .navegacion-principal a:conteins(\'Invitados\')').addClass('activo');

    /* Menú fijo */
    var windowHeight = $(window).height();
    var barHeight = $('.barra').innerHeight();
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if(scroll > windowHeight) {
            $('.barra').addClass('fixed');
            $('body').css({'margin-top': barHeight+'px'});
        } else {
            $('.barra').removeClass('fixed');
            $('body').css({'margin-top': '0'});
        }
    });

    /* Menú Responsive */
    $('.menu-movil').on('click', function() {
        $('.navegacion-principal').slideToggle();
    });

    /* Programa de Conferencias */
    $('div.ocultar').hide();
    $('.programa-evento .info-curso:first').show();
    $('.menu-programa a:first').addClass('activo');

    $('.menu-programa a').on('click', function() {
        $('.menu-programa a').removeClass('activo');
        $(this).addClass('activo');
        var enlace = $(this).attr('href');
        $(enlace).fadeIn(1000);

        return false;
    });

    /* Animaciones para los numeros */
    var resumenLista = jQuery('.resumen-evento');
    if(resumenLista.length > 0) {
        $('.resumen-evento').waypoint(function() {
            $('.resumen-numero li:nth-child(1) p').animateNumber({ number: 6}, 1200);
            $('.resumen-numero li:nth-child(2) p').animateNumber({ number: 15}, 1200);
            $('.resumen-numero li:nth-child(3) p').animateNumber({ number: 3}, 1500);
            $('.resumen-numero li:nth-child(4) p').animateNumber({ number: 9}, 1500);
        }, {
            offset: '60%'
        });
    }
    
    /* Cuenta regresiva */
    $('.cuenta-regresiva').countdown('2019/12/10 09:00:00', function(event) {
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));
    });

    /* Colorbox */

    $('.invitado-info').colorbox({inline:true, width:"50%"});

});