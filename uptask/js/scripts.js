eventListeners();
// LIsta de proyectos
var listaProyectos = document.querySelector('ul#proyectos');

function eventListeners() {
    // Document Ready
    document.addEventListener('DOMContentLoaded', function() {
        actualizarProgreso();
    });

    // Boton para crear proyecto
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);

    // Boton para una nueva tarea
    document.querySelector('.nueva-tarea').addEventListener('click', agregarTarea);

    // Botones para las acciones de las tares
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);
}

function nuevoProyecto(e) {
    e.preventDefault();

    // Crea un <input> para el nombre del nuevo proyecto
    var nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML = '<input type="text" id="nuevo-proyecto">';
    listaProyectos.appendChild(nuevoProyecto);

    // Seleccionar el id con el nuevo proyecto
    var inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    // Al presionar enter crea el proyecto
    inputNuevoProyecto.addEventListener('keypress', function(e) {
        var tecla = e.which || e.keyCode;

        if(tecla === 13) {
            guardarProyectoDB(inputNuevoProyecto.value);
            listaProyectos.removeChild(nuevoProyecto);
        }
    });
}

function guardarProyectoDB(nombreProyecto) {
    // Crear llamado ajax
    var xhr = XMLHttpRequest();

    // Enviar datos por formdata
    var datos = new FormData();
    datos.append('proyecto', nombreProyecto);
    datos.append('accion', 'crear');

    // Abrir la conexión
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // En la carga
    xhr.onload = function() {
        if(this.state === 200) {
            // Obtener datos de la respuesta
            var respuesta = JSON.parse(xhr.responseText);
            var proyecto = respuesta.nombre_proyecto,
                id_proyecto = respuesta.id_insertado,
                tipo = respuesta.tipo,
                resultado = respuesta.respuesta;

            // Comprobar la inserción
            if(resultado  === 'correcto') {
                // Fue exitoso
                if(tipo === 'crear') {
                    // Se creó un nuevo proyecto
                    // Inyectar en el HTML
                    var nuevoProyecto = document.createElement('li');
                    nuevoProyecto.innerHTML = `
                        <a href="index.php?id_proyecto=proyecto:${id_proyecto}" id="${id_proyecto}">
                            ${proyecto}
                        </a>
                    `;
                    // Agregar al HTML
                    listaProyectos.appendChild(nuevoProyecto);

                    // Enviar alerta
                    swal({
                        type: 'success',
                        title: 'Proyecto Creado',
                        text: 'El proyecto: ' + proyecto + ' se creó correctamente'
                    })
                    .then(resultado => {
                        if(resultado.value) {
                            // Redireccionar a la nueva url
                            window.location.href = 'index.php?id_proyecto=' + id_proyecto
                        }
                    });
                } else {
                    // Se actualizó o se elimino
                }
            } else {
                // Hubo un error
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'Hubo un error!'
                });
            }
        }
    }

    // Enviar el request
    xhr.send(datos);
}

// Agregar una nueva tarea al proyecto actual
function agregarTarea(e) {
    e.preventDefault();

    var nombreTarea = document.querySelector('.nombre-tarea').value;

    // Validar que el campo tenga algo escrito
    if(nombreTarea === '') {
        swal({
            type: 'error',
            title: 'Error',
            text:'Tarea no puede ir vacía'
        });
    } else {
        // La tarea tiene algo, insertar en PHP

        // Crear llamado ajax
        var xhr = new XMLHttpRequest();

        // Crear formdata
        var datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', document.querySelector('#id_proyecto').value);

        // Abrir conexión
        xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

        // Ejecutarlo y respuesta
        xhr.onload = function() {
            if(this.status === 200) {
                // Todo correcto
                var respuesta = JSON.parse(xhr.responseText);
                // Asignar valores
                var resultado = respuesta.respuesta,
                    tarea = respuesta.tarea,
                    id_insertado = respuesta.id_insertado,
                    tipo = respuesta.tipo;

                if(resultado === 'correcto') {
                    // Se agregó correctamente
                    if(tipo === 'crear') {
                        // Lanzar la alerta
                        swal({
                            type: 'success',
                            title: 'Tarea Creada',
                            text: 'La tarea: ' + tarea + ' se creó correctamente'
                        });

                        // Seleccionar el parrafo con la lista vacía
                        var parrafoListaVacia = document.querySelectorAll('.lista-vacia');
                        if(parrafoListaVacia.lenght > 0) {
                            document.querySelector('.lista-vacia').remove();
                        }

                        // Construir el template
                        var nuevaTarea = document.createElement('li');
                        
                        // Agregamos el ID
                        nuevaTarea.id = 'tarea:' + id_insertado;

                        // Agregar la clase tares
                        nuevaTarea.classList.add('tarea');

                        // Construir el HTML
                        nuevaTarea.innerHTML = `
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        `;

                        // Agregarlo al HTML
                        var listado = document.querySelector('listado-pendientes ul');
                        listado.appendChild(nuevaTarea);

                        // Limpiar el formulario
                        document.querySelector('.agregar-tarea').reset();

                        // Actualizar el progreso
                        actualizarProgreso()
                    }
                } else {
                    // Hubo un error
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Hubo un error'
                    });
                }
            }
        }

        // Enviar consulta
        xhr.send(datos);
    }
}

// Cambia el estado de las tareas o las elimina
function accionesTareas(e) {
    e.preventDefault();

    if(e.target.classList.contains('fa-check-circle')) {
        if(e.target.classList.contains('completo')) {
            e.target.classList.remove('completo');
            cambiarEstadoTarea(e.target, 0);
        } else {
            e.target.classList.add('completo');
            cambiarEstadoTarea(e.target, 1);
        }
    }

    if(e.target.classList.contains('fa-trash')) {
        swal({
            title: 'Seguro(a)?',
            text: 'Esta acción no se puede deshacer',
            type:'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar'
        })
        .then((result) => {
            if(result.value) {
                var tareaEliminar = e.target.parentElement.parentElement;
                // Borrar de la BD
                eliminarTareaBD(tareaEliminar);

                // Borrar del HTML
                tareaEliminar.remove();

                swal(
                    'Eliminado!',
                    'La tarea de eliminada!',
                    'success'
                )
            }
        });
    }
}

// Completa o descompleta la tarea
function cambiarEstadoTarea(tarea, estado) {
    var id_tarea = tarea.parentElement.parentElement.id.split(':');

    // Crear llamado ajax
    var chr = new XMLHttpRequest();

    // Información
    var datos = new FormData();
    datos.append('id', id_tarea[1]);
    datos.append('accion', 'actualizar');
    datos.append('estado', estado);

    // Abrir la conexión
    xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

    // On load
    xhr.onload = function() {
        if(this.status === 200) {
            console.log(JSON.parse(xhr.responseText));

            // Actualizar el progreso
            actualizarProgreso()
        }
    }

    // Enviar la petición
    xhr.send(datos);
}

// Elimina las tareas de la base de datos
function eliminarTareaBD(tarea) {
    var id_tarea = tarea.id.split(':');

    // Crear llamado ajax
    var chr = new XMLHttpRequest();

    // Información
    var datos = new FormData();
    datos.append('id', id_tarea[1]);
    datos.append('accion', 'eliminar');

    // Abrir la conexión
    xhr.open('POST', 'inc/modelos/modelo-tareas.php', true);

    // On load
    xhr.onload = function() {
        if(this.status === 200) {
            console.log(JSON.parse(xhr.responseText));

            // Comprobar que haya tareas restantes
            var listaTareasRestantes = document.querySelectorAll('li.tarea');
            if(listaTareasRestantes.lenght === 0) {
                document.querySelector('.listado-pendientes ul').innerHTML = "<p class='lista-vacia'>No hay tareas en este proyecto</p>";
            }

            // Actualizar el Progreso
            actualizarProgreso()
        }
    }

    // Enviar la petición
    xhr.send(datos);
}

// Actualiza el avance del Proyecto
function  actualizarProgreso() {
    // Obtener todas la tareas
    const tareas = document.querySelectorAll('li.tarea');

    // Obtener las tareas completadas
    const tareasCompletadas = document.querySelectorAll('i.completo');

    // Determinar el avance
    const avance = Math.round((tareasCompletadas.lenght / tareas.lenght) * 100);

    // Asignar el avance a la barra
    const porcentaje = document.querySelector('#porcentaje');
    porcentaje.style.width = avance + '%';

    // Mostrar una alerta al completar el 100
    if(avance === 100) {
        swal({
            type: 'success',
            title: 'Proyecto Terminado',
            text: 'Ya no tienes tareas pendientes'
        });
    }
}