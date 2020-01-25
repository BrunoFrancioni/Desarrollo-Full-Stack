// Tipos de datos

//string 
const nombre = "Juan";

//numero
const edad = 18;

//boolean
let aprendiendoJS = true;
consule.log(typeof aprendiendoJS);

//null
let hijos = null;
console.log(typeof hijos);




//Arreglos

const numero = [1, 2, 3, 4, 5];
console.log(numero[2]);
console.log(Array.isArray(numero));
numero.push(6);

// Objetos

const persona = {
    nombre: 'Juan',
    apellido: 'Barraza',
    edad: 18
}

console.log(persona.edad);

// Template Strings

const name = 'Juan';
const trabajo = 'Desarrollador Web';

console.log('Nombre: ' + name + ', Trabajo: ' + trabajo);
console.log(`Nombre: $(name), Trabajo: $(trabajo)`);

// Funciones

function saludar(nombre){
    console.log(`Hola $(nombre)`);
}

saludar('Bruno');

// IIFE

(function(tecnologia){
    console.log('Aprendiendo ' + tecnologia);
})('Javascript');

//Funciones dentro de objetos

let musica = {
    reproducir: function(cancion){
        console.log('Reproduciendo ' + musica);
    },
    pausar: function(){
        console.log('Pausada...');
    }
}

musica.reproducir('Holala');
musica.pausar();

// Object Constructor

class Tarea{
    constructor(nombre, urgencia){
        this.nombre = nombre;
        this.urgencia = urgencia;   
    }
}

const tarea1 = new Tarea('Aprender Javascript', 'Urgente');

// Fechas

let valor = new Date();
console.log(valor);
valor = valor.getDate();
valor = valor.getDay();
valor = valor.getFullYear();

// For

for(let i = 0; i < 10; i++){
    console.log('Jejox');
}

// Filter

const personas = [
    {nombre: 'Juan', edad: 20},
    {nombre: 'Pedro', edad: 18},
    {nombre: 'Carla', edad: 26},
    {nombre: 'Ana', edad: 27}
];

const mayores = personas.filter(persona => {
    return persona.edad > 25
});

// Fetch API

descargarUsuarios(30);

function descargarUsuarios(cantidad) {
    const api = `https://api.randomouser.com/?nat=US&results=${cantidad}`;

    // llamadi a fetch

    fetch(api)
        .then(respuesta => respuesta.json())
        .then(datos => imprimirHTML(datos.results));
}

function imprimirHTML(datos) {
    datos.forEach(usuario => {
        const li = document.createElement('li');

        const {name: {first}, name: {last}, picture : {medium}, nat} = usuario;

        li.innerHTML = `
            Nombre: ${first} ${last}
            País: ${nat}
            imagen: <img src="${medium}">
        `;

        document.querySelector('#app').appendChild(li);
    });
}