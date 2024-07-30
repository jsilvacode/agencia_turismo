<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $habitaciones = $conn->real_escape_string($_POST['habitaciones']);
    $tarifa = $conn->real_escape_string($_POST['tarifa']);

    $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
            VALUES ('$nombre', '$ubicacion', $habitaciones, $tarifa)";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo hotel registrado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>