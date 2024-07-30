<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $conn->real_escape_string($_POST['id_cliente']);
    $fecha_reserva = $conn->real_escape_string($_POST['fecha_reserva']);
    $id_vuelo = $conn->real_escape_string($_POST['id_vuelo']);
    $id_hotel = $conn->real_escape_string($_POST['id_hotel']);

    $sql = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
            VALUES ($id_cliente, '$fecha_reserva', $id_vuelo, $id_hotel)";

    if ($conn->query($sql) === TRUE) {
        echo "Nueva reserva registrada con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>