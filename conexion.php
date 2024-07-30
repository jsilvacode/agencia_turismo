<?php
$servername = "127.0.0.1";
$username = "root";
$password = "123456";
$dbname = "agencia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear las tablas si no existen
$sql = "CREATE TABLE IF NOT EXISTS VUELO (
    id_vuelo INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    origen VARCHAR(30) NOT NULL,
    destino VARCHAR(30) NOT NULL,
    fecha DATE NOT NULL,
    plazas_disponibles INT(3) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creando tabla VUELO: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS HOTEL (
    id_hotel INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(50) NOT NULL,
    habitaciones_disponibles INT(3) NOT NULL,
    tarifa_noche DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creando tabla HOTEL: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS RESERVA (
    id_reserva INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT(6) NOT NULL,
    fecha_reserva DATE NOT NULL,
    id_vuelo INT(6) UNSIGNED,
    id_hotel INT(6) UNSIGNED,
    FOREIGN KEY (id_vuelo) REFERENCES VUELO(id_vuelo),
    FOREIGN KEY (id_hotel) REFERENCES HOTEL(id_hotel)
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creando tabla RESERVA: " . $conn->error;
}
?>