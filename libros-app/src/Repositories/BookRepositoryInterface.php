<?php

interface BookRepositoryInterface {
    public function create(Book $book);
    public function read($id);
    public function update(Book $book);
    public function delete($id);
    public function getAll();
}

?>

