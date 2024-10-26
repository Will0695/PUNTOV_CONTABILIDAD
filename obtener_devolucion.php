<?php
include 'db.php'; // Conexión a la base de datos

// Verifica que se haya enviado un ID de devolución
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convierte el ID a entero para evitar inyección SQL

    // Consulta para obtener la devolución por ID
    $query = "SELECT * FROM devoluciones WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los datos de la devolución
        $devolucion = $result->fetch_assoc();
        echo json_encode($devolucion); // Enviar datos como JSON
    } else {
        echo json_encode(["error" => "Devolución no encontrada"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "ID de devolución no proporcionado"]);
}

$conn->close();
?>
