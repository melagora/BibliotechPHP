<?php
/**
 * Clase Database
 * 
 * Esta clase gestiona el almacenamiento de datos en archivos JSON. 
 * Permite guardar y leer los datos de manera temporal durante la ejecución del programa.
 */
class Database {
    /**
     * @var string $filePath Ruta del archivo donde se guardan los datos en formato JSON.
     */
    private $filePath = "../data/biblioteca.json"; // Asegúrate de que este directorio exista

    /**
     * Método para obtener los datos almacenados en el archivo JSON.
     * 
     * Lee el archivo JSON y devuelve los datos en forma de array.
     * Si el archivo no existe, devuelve un array vacío.
     * 
     * @return array Datos almacenados en el archivo JSON.
     */
    public function getConnection() {
        // Si el archivo no existe, devolvemos un array vacío
        if (!file_exists($this->filePath)) {
            return [];
        }

        // Leer el archivo JSON y devolver los datos como array
        $data = file_get_contents($this->filePath);
        return json_decode($data, true);
    }

    /**
     * Método para guardar los datos en el archivo JSON.
     * 
     * Convierte el array de datos a formato JSON y lo guarda en el archivo.
     * 
     * @param array $data Los datos que se desean guardar.
     */
    public function saveData($data) {
        // Convertir los datos a formato JSON y guardarlos en el archivo
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $jsonData);
    }

    /**
     * Método para eliminar el archivo de datos al cerrar el programa.
     * 
     * Elimina el archivo JSON que contiene los datos.
     */
    public function closeConnection() {
        if (file_exists($this->filePath)) {
            unlink($this->filePath); // Eliminar el archivo
        }
    }
}
?>
