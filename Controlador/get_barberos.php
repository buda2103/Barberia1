<?php
require_once '../modelo/config.php';

$query = "SELECT id, nombre FROM personal WHERE estado = 1 ORDER BY nombre";
$result = $conn->query($query);

$barberos = [];
while ($row = $result->fetch_assoc()) {
    $barberos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($barberos);
?>
