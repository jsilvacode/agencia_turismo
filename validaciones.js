function validarVuelo() {
    var origen = document.getElementById("origen").value;
    var destino = document.getElementById("destino").value;
    var fecha = document.getElementById("fecha").value;
    var plazas = document.getElementById("plazas").value;
    var precio = document.getElementById("precio").value;

    if (origen == "" || destino == "" || fecha == "" || plazas == "" || precio == "") {
        alert("Todos los campos son obligatorios");
        return false;
    }

    if (isNaN(plazas) || isNaN(precio)) {
        alert("Plazas y precio deben ser números");
        return false;
    }

    return true;
}

function validarHotel() {
    var nombre = document.getElementById("nombre").value;
    var ubicacion = document.getElementById("ubicacion").value;
    var habitaciones = document.getElementById("habitaciones").value;
    var tarifa = document.getElementById("tarifa").value;

    if (nombre == "" || ubicacion == "" || habitaciones == "" || tarifa == "") {
        alert("Todos los campos son obligatorios");
        return false;
    }

    if (isNaN(habitaciones) || isNaN(tarifa)) {
        alert("Habitaciones y tarifa deben ser números");
        return false;
    }

    return true;
}

function validarReserva() {
    var id_cliente = document.getElementById("id_cliente").value;
    var fecha_reserva = document.getElementById("fecha_reserva").value;
    var id_vuelo = document.getElementById("id_vuelo").value;
    var id_hotel = document.getElementById("id_hotel").value;

    if (id_cliente == "" || fecha_reserva == "" || id_vuelo == "" || id_hotel == "") {
        alert("Todos los campos son obligatorios");
        return false;
    }

    if (isNaN(id_cliente) || isNaN(id_vuelo) || isNaN(id_hotel)) {
        alert("ID de cliente, vuelo y hotel deben ser números");
        return false;
    }

    return true;
}