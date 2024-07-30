<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT h.id_hotel, h.nombre, h.ubicacion, 
               COUNT(r.id_reserva) as num_reservas
        FROM HOTEL h
        LEFT JOIN RESERVA r ON h.id_hotel = r.id_hotel
        GROUP BY h.id_hotel, h.nombre, h.ubicacion
        HAVING COUNT(r.id_reserva) > 2
        ORDER BY num_reservas DESC";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si la consulta se ejecutó correctamente
if ($result === FALSE) {
    die("Error en la consulta: " . $conn->error);
}

// Imprimir el encabezado HTML
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Consulta de Hoteles</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>";

echo "<h2>Hoteles con más de 2 reservas</h2>";

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Hotel</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Número de Reservas</th>
            </tr>";

    // Imprimir los datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["id_hotel"]) . "</td>
                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                <td>" . htmlspecialchars($row["ubicacion"]) . "</td>
                <td>" . htmlspecialchars($row["num_reservas"]) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No se encontraron hoteles con más de dos reservas.</p>";
}

// Cerrar la conexión
$conn->close();

echo "</body></html>";
?>