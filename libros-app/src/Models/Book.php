<?php

//representa el modelo de datos de un libro
class Book {
    public $id;
    public $title;
    public $author;
    public $anio;
    public $isbn;
    public $description;
    public $cover;

    public function __construct($title, $author, $anio, $isbn, $description, $cover, $id=null) {
        $this->title = $title;
        $this->author = $author;
        $this->anio = $anio;
        $this->isbn = $isbn;
        $this->description = $description;
        $this->cover = $cover;
        $this->id = $id;
    }
}

?>