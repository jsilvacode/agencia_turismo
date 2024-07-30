<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $conn->real_escape_string($_POST['origen']);
    $destino = $conn->real_escape_string($_POST['destino']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $plazas = $conn->real_escape_string($_POST['plazas']);
    $precio = $conn->real_escape_string($_POST['precio']);

    $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
            VALUES ('$origen', '$destino', '$fecha', $plazas, $precio)";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo vuelo registrado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>