

jQuery(document).ready(function() {
    'use strict';

    var asiento = "<div class=\"asiento\"></div>";
    
    $('button .boton-agregar').on('click', function() {
        var asiento = "<div class=\"asiento\"></div>";
    });

    /* Agregar linea */
    $('#boton-add').on('click', function() {
        $('.tbody-add').append(
        "<tr class=\"linea\"><th scope=\"row\"></th><td></td><td><input type=\"text\" placeholder=\"Concepto\" class=\"form-control\"></td><td><input type=\"text\" placeholder=\"Debe\" class=\"form-control\"></td><td><input type=\"text\" placeholder=\"Haber\" class=\"form-control\"></td</tr>");
    
        $('#guardar-asiento').prop('disabled', 'disabled');
        return false;
    });

    asiento = $('.tbody-add').clone();

    /* Eliminar linea */
    $('#boton-less').on('click', function() {
        if($('.tbody-add tr').length > 1) {
            $('.tbody-add tr:last').remove();
            $('#guardar-asiento').prop('disabled', 'disabled');
        }

        return false;
    });

    /* Calcular Asiento */
    $('#boton-calcular').on('click', function() {
        var debe = 0;
        var haber = 0;

        $('td:nth-child(4) input').each(function() {
            debe += parseInt($(this).val(), 10);
        });

        console.log(debe);
        
        $('td:nth-child(5) input').each(function() {
            haber += parseInt($(this).val(), 10);
        });

        console.log(haber);

        if((debe - haber) == 0) {
            $('#guardar-asiento').prop('disabled', false);
        }
    });
    
});