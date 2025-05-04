document.addEventListener("DOMContentLoaded", function () {

    const boton_opciones = document.getElementById("menu_opciones");
    const menu_lateral = document.getElementById("menu-lateral");
    const boton_volver = document.getElementById("solo_mobil");
    const mostrar_menu = document.getElementById("gestion-usuarios");
    const sub_menu = document.getElementById("sub_menu");
    const btn_cerrar = document.getElementById("btn_cerrar");
    const cerrar_modal = document.querySelector(".carta");

    let posicion_inicial = 0;

    // Abrir menú
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

    mostrar_menu.addEventListener("click", function () {
       // Evita que el <a href="#"> salte arriba
        sub_menu.classList.toggle("mostrar");
    });




    btn_cerrar.addEventListener("click", function () {
        cerrar_modal.style.display = (cerrar_modal.style.display === "block") ? "none" : "block";
      });
      
     
      document.addEventListener("click", function (event) {
       
        if (cerrar_modal.style.display === "block") {
          
          if (!cerrar_modal.contains(event.target) && event.target !== btn_cerrar) {
            cerrar_modal.style.display = "none";
          }
        }
      });

    
    

});
