<?php

class OpenLibraryApiClient {
    private $baseUrl;

    public function __construct() {
        $this->baseUrl = 'https://openlibrary.org/api/books';
    }

    private function request($params) {
        $url = $this->baseUrl . '?' . http_build_query($params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);

        // Manejo de errores
        if (curl_errno($ch)) {
            throw new Exception("Error en la llamada a la API de Open Library: " . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    public function getBookByISBN($isbn) {
        $params = [
            'bibkeys' => $isbn,
            'format' => 'json',
            'jscmd' => 'data'
        ];
        return $this->request($params);
    }
}
?>