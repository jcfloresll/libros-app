<?php 

//implementa la lógica de acceso a datos
include_once 'BookRepositoryInterface.php';
include_once '../src/Models/Book.php';
include_once '../config/database.php';

class BookRepository implements BookRepositoryInterface {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(Book $book) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO libros (title, author, anio, isbn, description, cover) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$book->title, $book->author, $book->anio, $book->isbn, $book->description, $book->cover])) {
                return [ 
                    'success' => true, 
                    'message' => 'El libro se ha creado correctamente.',
                    'data' => []
                ];
            }
        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error creando : '.$e->getMessage() , 'data' => [] ];
        }
        
    }

    public function read($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch();
            $libro = [];
            $libro=new Book($data['title'], $data['author'], $data['anio'], $data['isbn'], $data['description'],$data['cover'], $data['id']);
            return [ 
                'success' => true, 
                'message' => '',
                'data' => $libro
            ];
        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error creando : '.$e->getMessage() , 'data' => [] ];
        }
        
    }

    public function update(Book $book) {
        try {
            $stmt = $this->pdo->prepare("UPDATE libros SET title = ?, author = ?, anio = ?, isbn = ?, description = ?, cover = ? WHERE id = ?");
            $stmt->execute([$book->title, $book->author, $book->anio, $book->isbn, $book->description, $book->cover, $book->id]);   
            return [ 
                'success' => true, 
                'message' => 'El libro se ha actualizado correctamente.',
                'data' => []
            ];
        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error actualizando : '.$e->getMessage() , 'data' => [] ];
        }
        
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM libros WHERE id = ?");
            $stmt->execute([$id]);
            return [ 
                'success' => true, 
                'message' => 'El libro se ha eliminado correctamente.',
                'data' => []
            ];

        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error eliminando : '.$e->getMessage() , 'data' => [] ];
        }
        
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM libros");
            $libros = [];
            while ($data = $stmt->fetch()) {
                $libros[] = new Book($data['title'], $data['author'], $data['anio'], $data['isbn'], $data['description'], $data['cover'], $data['id']);
            }
            return [ 
                'success' => true, 
                'message' => 'El libro se ha eliminado correctamente.',
                'data' => $libros
            ];
        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error recuperando todo el listado : '.$e->getMessage() , 'data' => [] ];
        }
        
    }

    public function getSearchByTerm($searchTerm) {
        try {
            $searchTerm = '%'.$searchTerm.'%';
            $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE title LIKE ? OR author LIKE ?");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results = [];
            while ($data = $stmt->fetch()) {
                $results[]= new Book($data['title'], $data['author'], $data['anio'], $data['isbn'], $data['description'], $data['cover'], $data['id']);
            }
            return [ 
                'success' => true, 
                'message' => '',
                'data' => $results
            ];
        } catch (Exception $e) {
            return [ 'success' => false, 'message' => 'Error buscando : '.$e->getMessage() , 'data' => [] ];
        }
        
    }
}

?>