document.addEventListener("DOMContentLoaded", function () {
    const boton_opciones = document.getElementById("menu_opciones");
    const menu_lateral = document.getElementById("menu-lateral");
    const boton_volver = document.getElementById("solo_mobil");

    // Menús
    const mostrar_menu_usuarios = document.getElementById("gestion-usuarios");
    const submenu_usuarios = document.querySelector(".gestion-submenu");

    const mostrar_menu_usuario = document.getElementById("cerrado-usuarios");
    const submenu_usuario = document.querySelector(".usuario-submenu");

    // Abrir/cerrar menú lateral
    boton_opciones.addEventListener("click", function () {
        menu_lateral.style.transform = "translateX(0)";
    });

    boton_volver.addEventListener("click", function () {
        menu_lateral.style.transform = "translateX(-100%)";
    });

    menu_lateral.addEventListener('touchstart', function (evento) {
        posicion_inicial = evento.touches[0].clientX;
    });

    menu_lateral.addEventListener('touchend', function (evento) {
        const posicion_final = evento.changedTouches[0].clientX;
        const diferencia = posicion_final - posicion_inicial;
        if (diferencia < -50) {
            menu_lateral.style.transform = "translateX(-100%)";
        }
    });

    // Toggle para submenús
    mostrar_menu_usuarios.addEventListener("click", function () {
        submenu_usuarios.classList.toggle("mostrar");
    });

    mostrar_menu_usuario.addEventListener("click", function () {
        submenu_usuario.classList.toggle("mostrar");
    });
});
