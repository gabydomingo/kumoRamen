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

//

