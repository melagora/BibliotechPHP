<?php
require_once "../config/database.php"; // Importamos la clase Database
require_once "../src/Models/Prestamo.php"; // Importamos el modelo Prestamo

/**
 * Controlador para manejar operaciones relacionadas con préstamos.
 */
class PrestamoController {
    private $db; // Instancia de la clase Database
    private $model; // Instancia del modelo Prestamo

    /**
     * Constructor que inicializa el modelo de préstamos con los datos cargados desde el archivo JSON.
     */
    public function __construct() {
        $this->db = new Database(); // Iniciamos la clase Database
        $data = $this->db->getConnection(); // Obtenemos los datos del archivo JSON
        $this->model = new Prestamo($data); // Pasamos los datos obtenidos al modelo
    }

    /**
     * Registra un nuevo préstamo.
     * 
     * @param int $libro_id ID del libro a prestar.
     * @param int $usuario_id ID del usuario que solicita el préstamo.
     * @return bool True si el préstamo se registró correctamente, false si falló.
     * @throws Exception Si hay errores en las validaciones o al registrar el préstamo.
     */
    public function registrarPrestamo($libro_id, $usuario_id) {
        // Validar entradas
        if (empty($libro_id) || empty($usuario_id)) {
            throw new Exception("El ID del libro y el ID del usuario son obligatorios.");
        }

        if (!is_numeric($libro_id) || !is_numeric($usuario_id)) {
            throw new Exception("El ID del libro y el ID del usuario deben ser numéricos.");
        }

        // Asignar valores al modelo
        $this->model->libro_id = $libro_id;
        $this->model->usuario_id = $usuario_id;

        // Intentar registrar el préstamo
        try {
            return $this->model->registrarPrestamo(); // Registra el préstamo y guarda los datos en el archivo JSON
        } catch (Exception $e) {
            throw new Exception("Error al registrar el préstamo: " . $e->getMessage());
        }
    }

    /**
     * Marca un préstamo como devuelto.
     * 
     * @param int $prestamo_id ID del préstamo a marcar como devuelto.
     * @return bool True si se marcó correctamente, false si falló.
     * @throws Exception Si el ID no es válido o ocurre un error al actualizar el préstamo.
     */
    public function registrarDevolucion($prestamo_id) {
        if (empty($prestamo_id) || !is_numeric($prestamo_id)) {
            throw new Exception("El ID del préstamo es obligatorio y debe ser numérico.");
        }

        try {
            return $this->model->registrarDevolucion($prestamo_id); // Marca el préstamo como devuelto y guarda los cambios
        } catch (Exception $e) {
            throw new Exception("Error al registrar la devolución: " . $e->getMessage());
        }
    }
}
?>
