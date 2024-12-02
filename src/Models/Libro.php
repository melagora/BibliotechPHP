<?php
/**
 * Clase Libro
 * 
 * Esta clase gestiona los libros, permitiendo agregar, editar, eliminar y buscar libros.
 * Los libros se almacenan temporalmente en un archivo JSON durante la ejecución del programa.
 */
class Libro {
    private $data; // Datos de los libros almacenados en un array
    public $id;
    public $titulo;
    public $autor;
    public $categoria;
    public $estado;

    /**
     * Constructor de la clase Libro.
     * 
     * @param array $data Datos de los libros leídos del archivo JSON.
     */
    public function __construct($data) {
        $this->data = $data; // Almacena los datos del archivo JSON
    }

    /**
     * Agrega un nuevo libro a los datos.
     * 
     * @return bool Devuelve true si el libro fue agregado exitosamente.
     */
    public function agregarLibro() {
        $newBook = [
            'id' => count($this->data) + 1, // Asignar un nuevo ID basado en la cantidad de libros
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'categoria' => $this->categoria,
            'estado' => $this->estado
        ];

        $this->data[] = $newBook; // Agregar el nuevo libro al array de datos
        $this->guardarDatos(); // Guardar los cambios en el archivo JSON
        return true;
    }

    /**
     * Busca libros en los datos según el criterio dado.
     * 
     * @param string $criterio El criterio de búsqueda (puede ser título, autor, categoría).
     * @return array Lista de libros que coinciden con el criterio.
     */
    public function buscarLibros($criterio) {
        $result = [];
        foreach ($this->data as $book) {
            if (stripos($book['titulo'], $criterio) !== false || 
                stripos($book['autor'], $criterio) !== false || 
                stripos($book['categoria'], $criterio) !== false) {
                $result[] = $book;
            }
        }
        return $result;
    }

    /**
     * Edita un libro en los datos.
     * 
     * @param int $id El ID del libro a editar.
     * @return bool Devuelve true si la edición fue exitosa.
     */
    public function editarLibro($id) {
        foreach ($this->data as $index => $book) {
            if ($book['id'] == $id) {
                $this->data[$index]['titulo'] = $this->titulo;
                $this->data[$index]['autor'] = $this->autor;
                $this->data[$index]['categoria'] = $this->categoria;
                $this->data[$index]['estado'] = $this->estado;
                $this->guardarDatos(); // Guardar los cambios en el archivo JSON
                return true;
            }
        }
        return false; // Si no se encuentra el libro con el ID dado
    }

    /**
     * Elimina un libro de los datos.
     * 
     * @param int $id El ID del libro a eliminar.
     * @return bool Devuelve true si el libro fue eliminado correctamente.
     */
    public function eliminarLibro($id) {
        foreach ($this->data as $index => $book) {
            if ($book['id'] == $id) {
                unset($this->data[$index]); // Eliminar el libro del array
                $this->data = array_values($this->data); // Reindexar el array
                $this->guardarDatos(); // Guardar los cambios en el archivo JSON
                return true;
            }
        }
        return false;
    }

    /**
     * Guarda los datos de los libros en el archivo JSON.
     */
    private function guardarDatos() {
        $filePath = "../data/biblioteca.json"; // Ruta donde se guarda el archivo
        file_put_contents($filePath, json_encode($this->data, JSON_PRETTY_PRINT)); // Guardar los datos
    }
}
?>
