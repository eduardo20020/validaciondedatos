<?php
// Datos de conexión a la base de datos
$s = "localhost";
$u = "root";
$p = "";
$d = "peachepe";

try {
    // Crear la conexión
    $conn = new PDO("mysql:host=$s;dbname=$d", $u, $p);
    // Establecer el modo de error a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}

?>
