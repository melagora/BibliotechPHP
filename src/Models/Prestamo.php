<?php
/**
 * Clase Prestamo
 * 
 * Esta clase gestiona los préstamos, permitiendo registrar y actualizar préstamos en el archivo JSON.
 */
class Prestamo {
    private $data; // Datos de los préstamos almacenados en un array
    public $libro_id;
    public $usuario_id;
    public $estado;
    public $id;

    /**
     * Constructor de la clase Prestamo.
     * 
     * @param array $data Datos de los préstamos leídos del archivo JSON.
     */
    public function __construct($data) {
        $this->data = $data; // Almacena los datos del archivo JSON
    }

    /**
     * Registra un nuevo préstamo en los datos.
     * 
     * @return bool Devuelve true si el préstamo fue registrado correctamente.
     */
    public function registrarPrestamo() {
        // Validamos si ya existe un préstamo con el mismo libro y usuario
        foreach ($this->data as $prestamo) {
            if ($prestamo['libro_id'] == $this->libro_id && $prestamo['usuario_id'] == $this->usuario_id && $prestamo['estado'] == "Prestado") {
                throw new Exception("Este libro ya está prestado a este usuario.");
            }
        }

        // Crear un nuevo préstamo
        $newPrestamo = [
            'id' => count($this->data) + 1, // Asignar un nuevo ID basado en la cantidad de préstamos
            'libro_id' => $this->libro_id,
            'usuario_id' => $this->usuario_id,
            'estado' => "Prestado"
        ];

        $this->data[] = $newPrestamo; // Agregar el nuevo préstamo al array
        $this->guardarDatos(); // Guardar los datos actualizados en el archivo JSON
        return true;
    }

    /**
     * Marca un préstamo como devuelto.
     * 
     * @param int $prestamo_id ID del préstamo a marcar como devuelto.
     * @return bool Devuelve true si el préstamo fue actualizado correctamente.
     */
    public function registrarDevolucion($prestamo_id) {
        foreach ($this->data as $index => $prestamo) {
            if ($prestamo['id'] == $prestamo_id) {
                $this->data[$index]['estado'] = "Devuelto"; // Cambiar el estado a "Devuelto"
                $this->guardarDatos(); // Guardar los cambios en el archivo JSON
                return true;
            }
        }
        throw new Exception("No se encontró el préstamo con el ID dado.");
    }

    /**
     * Guarda los datos de los préstamos en el archivo JSON.
     */
    private function guardarDatos() {
        $filePath = "../data/prestamos.json"; // Ruta donde se guarda el archivo
        file_put_contents($filePath, json_encode($this->data, JSON_PRETTY_PRINT)); // Guardar los datos en el archivo
    }
}
?>
