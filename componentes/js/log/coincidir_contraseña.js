let input1 = document.getElementById("contrasena");
let input2 = document.getElementById("conf_contrasena");
let mensaje_error = document.getElementById("mensaje_err")
let btn = document.getElementById("btn_backend")

input2.addEventListener("keyup", () => {
    validarContraseña(input1, input2, mensaje_error, btn);
});

function validarContraseña(a, b, c, d) {
  
    const original = a.value;
    const confirmacion = b.value;

    console.log("Original:", original);
    console.log("Confirmación:", confirmacion);

    // Verificar si la confirmación es un prefijo de la contraseña original
    if (original.startsWith(confirmacion)) {
      
        b.style.background = "#fff";
        b.style.color = "var(--blanco)";
       
            b.style.border = "1px solid #ccc";
             c.style.display ="none";
              d.disabled=false;
    } else {
       
        b.style.background = "#FFF5F5";  // Solo una #
        b.style.color = "#E53E3E";
        b.style.border = "1.5px solid #E53E3E";
        c.style.display ="block";
        d.disabled=true;


    }
}
