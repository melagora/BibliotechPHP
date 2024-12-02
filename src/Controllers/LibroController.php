<?php
require_once "../config/database.php"; // Importamos la clase Database
require_once "../src/Models/Libro.php"; // Importamos el modelo Libro

class LibroController {
    private $db; // Instancia de la clase Database
    private $model; // Instancia del modelo Libro

    public function __construct() {
        $this->db = new Database(); // Iniciamos la clase Database
        $data = $this->db->getConnection(); // Obtenemos los datos del archivo JSON
        $this->model = new Libro($data); // Pasamos los datos obtenidos al modelo
    }

    /**
     * Agrega un nuevo libro al archivo JSON.
     * 
     * @param string $titulo Título del libro.
     * @param string $autor Autor del libro.
     * @param string $categoria Categoría del libro.
     * @return bool Devuelve true si el libro se ha agregado correctamente.
     */
    public function agregar($titulo, $autor, $categoria) {
        $this->model->titulo = $titulo;
        $this->model->autor = $autor;
        $this->model->categoria = $categoria;
        $this->model->estado = "Disponible";
        return $this->model->agregarLibro(); // Agrega el libro y guarda los datos en el archivo JSON
    }

    /**
     * Busca libros en el archivo JSON según el criterio proporcionado.
     * 
     * @param string $criterio El criterio de búsqueda (puede ser título, autor, categoría).
     * @return array Retorna los libros que coinciden con el criterio de búsqueda.
     */
    public function buscar($criterio) {
        return $this->model->buscarLibros($criterio); // Busca en el modelo según el criterio
    }

    /**
     * Edita un libro en el archivo JSON.
     * 
     * @param int $id ID del libro a editar.
     * @param string $titulo Título actualizado.
     * @param string $autor Autor actualizado.
     * @param string $categoria Categoría actualizada.
     * @param string $estado Estado del libro (disponible, prestado, etc).
     * @return bool Devuelve true si la edición fue exitosa.
     */
    public function editar($id, $titulo, $autor, $categoria, $estado) {
        $this->model->id = $id;
        $this->model->titulo = $titulo;
        $this->model->autor = $autor;
        $this->model->categoria = $categoria;
        $this->model->estado = $estado;
        return $this->model->editarLibro($id); // Edita el libro y guarda los cambios en el archivo JSON
    }

    /**
     * Elimina un libro del archivo JSON.
     * 
     * @param int $id ID del libro a eliminar.
     * @return bool Retorna true si el libro fue eliminado exitosamente.
     */
    public function eliminar($id) {
        return $this->model->eliminarLibro($id); // Elimina el libro del archivo JSON
    }
}
?>
