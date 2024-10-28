function loguear() {
    var user = document.getElementById("Usuario").value;
    var pasword = document.getElementById("contrasena").value;

    // Cambia estas credenciales por un backend real
    const validUser = "10155002-S";
    const validPassword = "93699";

    if (user === validUser && pasword === validPassword) {
        // Almacena en sessionStorage para que no se cierre la sesión fácilmente
        sessionStorage.setItem("loggedIn", "true");
        sessionStorage.setItem("usuario", user); // Almacenar el usuario
        sessionStorage.setItem("contrasena", pasword); // Almacenar la contraseña
        window.location = "login.html";
    } else {
        alert("Datos incorrectos");
    }

    // Prevenir el envío del formulario
    return false;
}

// Verifica si el usuario está logueado al cargar la página
window.onload = function() {
    if (!sessionStorage.getItem("loggedIn")) {
        window.location = "index.html"; // Redirige a la página de login si no está logueado
    } else {
        // Evita el almacenamiento en caché de esta página
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.pushState(null, null, location.href);
        };
    }
};

// Función para cerrar sesión
function cerrarSesion() {
    sessionStorage.removeItem("loggedIn"); // Elimina el estado de sesión
    window.location.replace("index.html"); // Cambia a replace para evitar que el usuario vuelva a la página de índice
}



