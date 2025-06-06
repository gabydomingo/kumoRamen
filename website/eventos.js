// Selecciona todos los enlaces de la navegación
const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

// Agrega un evento de clic a cada enlace
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    // Remueve la clase active de todos los enlaces
    navLinks.forEach(l => l.classList.remove('active'));
    // Agrega la clase active al enlace actual
    link.classList.add('active');
  });
});

// deberia dejar subrayada la seccion en la que estoy, pero solo la marca tipo hover (revisar el active)^^


// estilo y funcion del login y registro
//
//Ejecutando funciones
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

    //FUNCIONES

function anchoPage(){

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";   
    }
}

anchoPage();


    function iniciarSesion(){
        if (window.innerWidth > 850){
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "10px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        }else{
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register(){
        if (window.innerWidth > 850){
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "410px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}

////guardar en session storge
const form = document.getElementById('login');
const emailInput = document.getElementById('mail');
document.getElementById("btn__registrarse").addEventListener("click", register);

let data = JSON.parse(sessionStorage.getItem('formData')) || [];

if (form){ 
    form.addEventListener("submit",function (event) {
        const email = emailInput.value;   
        if(email){
            const newData = email;
            data.push(newData);
            saveDataToLocalStorage();
            window.location ="iniciar_sesion.php";
        }else{
            alert('Todos los datos son obligatorios')
        }
    })
}

function saveDataToLocalStorage() {
    sessionStorage.setItem('formData',JSON.stringify(data));
}

// 

document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.fixed-top');
    const contentWrapper = document.querySelector('.content-wrapper');
    
    if (header && contentWrapper) {
        contentWrapper.style.paddingTop = `${header.offsetHeight + 20}px`;
    }
});


