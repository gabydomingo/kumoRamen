const text = document.querySelector(".sec_text");

const textLoader = () => {
    setTimeout(() => {
        text.textContent = "Estudiante"
    }, 0);
    setTimeout(() => {
        text.textContent = "Desarrollador/Diseñador Web";
    }, 4000);
    setTimeout(() => {
        text.textContent = "software Developer";
    }, 8000);
}

textLoader()
setInterval(textLoader, 12000);