<?php
// Cargar el controlador de préstamos
require_once "../src/Controllers/PrestamoController.php";

// Crear una instancia del controlador
$controller = new PrestamoController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libro_id = $_POST['libro_id'] ?? null;
    $usuario_id = $_POST['usuario_id'] ?? null;

    try {
        // Intentar registrar el préstamo
        if ($controller->registrarPrestamo($libro_id, $usuario_id)) {
            $message = "Préstamo registrado con éxito.";
        } else {
            $message = "No se pudo registrar el préstamo. Por favor, verifica los datos.";
        }
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Préstamo</title>
</head>
<body>
    <h1>Registrar Préstamo</h1>
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div>
            <label for="libro_id">ID del Libro:</label>
            <input type="number" id="libro_id" name="libro_id" required>
        </div>
        <div>
            <label for="usuario_id">ID del Usuario:</label>
            <input type="number" id="usuario_id" name="usuario_id" required>
        </div>
        <button type="submit">Registrar Préstamo</button>
    </form>
</body>
</html>
