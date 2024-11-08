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


// evento tabla admin

$(document).ready(function() {
    var table = $('#reservasTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        columnDefs: [
            { 
                targets: -1, 
                orderable: false, 
                searchable: false 
            }
        ],
      
        drawCallback: function() {
            $('.dataTables_paginate .paginate_button').addClass('btn btn-sm btn-outline-primary mx-1');
        }
    });

    // Evento para editar reserva
    $('#reservasTable').on('click', '.btn-edit', function() {
        var idReserva = $(this).data('id');
        
        $.ajax({
            url: 'editar_reserva.php',
            method: 'GET',
            data: { id_reserva: idReserva },
            dataType: 'json',
            success: function(data) {
                console.log('Datos recibidos:', data);  // Depuración x1 
                
                if (data.success === false) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                    return;
                }

                $('#edit-id-reserva').val(data.id_reserva);
                $('#edit-platos').val(data.platos);
                $('#edit-personas').val(data.cantidad_personas);
                $('#edit-telefono').val(data.telefono);
                $('#edit-fecha').val(data.fecha);
                $('#edit-hora').val(data.hora);
                $('#edit-instrucciones').val(data.instrucciones);
                
                $('#editReservaModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', status, error);
                console.log('Respuesta del servidor:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo cargar la reserva: ' + error
                });
            }
        });
    });

    // Evento para guardar cambios
    $('#guardarCambios').click(function() {
        $.ajax({
            url: 'editar_reserva.php',
            method: 'POST',
            data: $('#editReservaForm').serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);  // Depuración x1000
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reserva Actualizada',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', status, error);
                console.log('Respuesta del servidor:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo guardar los cambios: ' + error
                });
            }
        });
    });

    // Evento para eliminar reserva
    $('#reservasTable').on('click', '.btn-delete', function() {
        var idReserva = $(this).data('id');
        var $row = $(this).closest('tr');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'eliminar_reserva.php',
                    method: 'POST',
                    data: { id_reserva: idReserva },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        
                        if (response.success) {
                            // Eliminar la fila de la tabla
                            table.row($row).remove().draw();
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Reserva eliminada',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud:', status, error);
                        console.log('Respuesta del servidor:', xhr.responseText);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de conexión',
                            text: 'No se pudo eliminar la reserva: ' + error
                        });
                    }
                });
            }
        });
    });
});
