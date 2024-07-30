<?php
require_once 'conexion.php';

// Función para mostrar errores
function mostrarError($mensaje)
{
    global $conn;
    die("Error: " . $mensaje . " " . $conn->error);
}

// 1. Consulta compleja para mostrar disponibilidad según preferencias del usuario
function mostrarDisponibilidad($conn, $origen, $destino, $fecha)
{
    $sql = "SELECT v.id_vuelo, v.origen, v.destino, v.fecha, v.plazas_disponibles, v.precio,
                   h.id_hotel, h.nombre as nombre_hotel, h.ubicacion, h.habitaciones_disponibles, h.tarifa_noche
            FROM VUELO v
            JOIN HOTEL h ON v.destino = h.ubicacion
            WHERE v.origen = ? AND v.destino = ? AND v.fecha = ? AND v.plazas_disponibles > 0 AND h.habitaciones_disponibles > 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $origen, $destino, $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Servicios disponibles</h2>";
        echo "<table border='1'><tr><th>Vuelo ID</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Plazas</th><th>Precio</th><th>Hotel</th><th>Habitaciones</th><th>Tarifa</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_vuelo'] . "</td>";
            echo "<td>" . $row['origen'] . "</td>";
            echo "<td>" . $row['destino'] . "</td>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . $row['plazas_disponibles'] . "</td>";
            echo "<td>" . $row['precio'] . "</td>";
            echo "<td>" . $row['nombre_hotel'] . "</td>";
            echo "<td>" . $row['habitaciones_disponibles'] . "</td>";
            echo "<td>" . $row['tarifa_noche'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron servicios disponibles para las preferencias seleccionadas.";
    }
}

// 2. Registrar diez reservas y mostrar el contenido
function registrarYMostrarReservas($conn)
{
    // Registrar 10 reservas
    for ($i = 1; $i <= 10; $i++) {
        $id_cliente = rand(1, 100);
        $fecha_reserva = date('Y-m-d', strtotime("+$i day"));
        $id_vuelo = rand(1, 3);  // Asumiendo que tienes al menos 3 vuelos
        $id_hotel = rand(1, 3);  // Asumiendo que tienes al menos 3 hoteles

        $sql = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $id_cliente, $fecha_reserva, $id_vuelo, $id_hotel);
        $stmt->execute();
    }
    echo "Se han registrado 10 reservas.<br>";

    // Mostrar el contenido de la tabla RESERVA
    $sql = "SELECT * FROM RESERVA";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Contenido de la tabla RESERVA</h2>";
        echo "<table border='1'><tr><th>ID Reserva</th><th>ID Cliente</th><th>Fecha Reserva</th><th>ID Vuelo</th><th>ID Hotel</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_reserva'] . "</td>";
            echo "<td>" . $row['id_cliente'] . "</td>";
            echo "<td>" . $row['fecha_reserva'] . "</td>";
            echo "<td>" . $row['id_vuelo'] . "</td>";
            echo "<td>" . $row['id_hotel'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay reservas registradas.";
    }
}

// 3. Consulta avanzada: número de reservas por hotel
function consultaAvanzadaHoteles($conn)
{
    $sql = "SELECT h.id_hotel, h.nombre, h.ubicacion, COUNT(r.id_reserva) as num_reservas
            FROM HOTEL h
            LEFT JOIN RESERVA r ON h.id_hotel = r.id_hotel
            GROUP BY h.id_hotel, h.nombre, h.ubicacion
            HAVING num_reservas > 2
            ORDER BY num_reservas DESC";

    $result = $conn->query($sql);

    echo "<h2>Hoteles con más de 2 reservas</h2>";
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID Hotel</th><th>Nombre</th><th>Ubicación</th><th>Número de Reservas</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_hotel'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['ubicacion'] . "</td>";
            echo "<td>" . $row['num_reservas'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron hoteles con más de dos reservas.";
    }
}

// Ejecutar las funciones
echo "<h1>Servicios Turísticos</h1>";

// Formulario para buscar disponibilidad
echo "<h2>Buscar disponibilidad</h2>";
echo "<form method='post'>";
echo "Origen: <input type='text' name='origen' required><br>";
echo "Destino: <input type='text' name='destino' required><br>";
echo "Fecha: <input type='date' name='fecha' required><br>";
echo "<input type='submit' name='buscar' value='Buscar'>";
echo "</form>";

if (isset($_POST['buscar'])) {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha = $_POST['fecha'];
    mostrarDisponibilidad($conn, $origen, $destino, $fecha);
}

registrarYMostrarReservas($conn);
consultaAvanzadaHoteles($conn);

$conn->close();
?>