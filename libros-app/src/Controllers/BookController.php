<?php 

//Este controlador manejará las operaciones CRUD:
include_once '../src/Repositories/BookRepository.php';

class BookController {
    private $bookRepository;

    public function __construct($pdo) {
        $this->bookRepository = new BookRepository($pdo);
    }

    public function create($title, $author, $anio, $isbn, $description, $cover) {
        $book = new Book($title, $author, $anio ,$isbn, $description, $cover);
        return $this->bookRepository->create($book);
    }

    public function read($id) {
        return $this->bookRepository->read($id);
    }

    public function update($id, $title, $author, $anio, $isbn, $description,  $cover) {
        $book = new Book($title, $author, $anio, $isbn, $description,  $cover, $id);
        return $this->bookRepository->update($book);
    }

    public function delete($id) {
        return $this->bookRepository->delete($id);
    }

    public function getAll() {
        return $this->bookRepository->getAll();
    }

    public function getSearchByTerm($searchTerm) {
        return $this->bookRepository->getSearchByTerm($searchTerm);
    }

}

?>