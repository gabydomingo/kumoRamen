<footer class="footer text-white">
    <p class="footer-message">
        Hecho por <a href="../PHP/index.php">Gabriel Domingo</a>
    </p>
    <p class="footer-copyright">
        Copyright 2024 - Todos los derechos reservados.
    </p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    const $form = document.querySelector('#form')
    $form.addEventListener('submit', handleSubmit)

    function handleSubmit(event) {
        event.preventDefault()
        const form = new FormData(this)
        trucazo.setAttribute('href',
            `mailto:domingogaby8@gmail.com?subject=${form.get('name')}${form.get('email')}&body=${form.get('message')}`)
        trucazo.click()
    }
</script>
</body>
</html>