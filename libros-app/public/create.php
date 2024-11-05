<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../config/config.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars(trim($_POST['author']), ENT_QUOTES, 'UTF-8');
    $anio = filter_var(trim($_POST['anio']), FILTER_SANITIZE_NUMBER_INT);
    $isbn = htmlspecialchars(trim($_POST['isbn']), ENT_QUOTES, 'UTF-8');
 
    $openLibraryClient = new OpenLibraryApiClient();
    
    if ($book = $openLibraryClient->getBookByISBN('ISBN:'.$isbn)) {
        $description='';
        if (isset($book['ISBN:'.$isbn]['notes'])) {
            $description=$book['ISBN:'.$isbn]['notes'];
        }
        $cover='';
        if (isset($book['ISBN:'.$isbn]['cover']['small'])) {
            $cover=$book['ISBN:'.$isbn]['cover']['small'];
        }

        $bookController = new BookController($pdo);
        $response=$bookController->create($title, $author, $anio, $isbn, $description, $cover);
        if ($response['success']) {
             // Encriptar el msg
             $plaintext =$response['message'].'-'.$secureKey;
             $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
             $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $secureKey, 0, $iv);
             $encodedData = base64_encode($iv . $ciphertext);
             header("Location: index.php?rsp=" . urlencode($encodedData));
             exit();
        }else{
            $mensaje=$response['message'];
        }
    }else{
        $mensaje='Error recuperando la info vía API, el ISBN no devolvió resultados.';
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de alta un libro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Dar de alta un Libro</h1>
        <a href="index.php" class="btn btn-primary mb-3">Volver al listado</a>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="author">Autor:</label>
                <input type="text" class="form-control" name="author" id="author" required>
            </div>

            <div class="form-group">
                <label for="anio">Año:</label>
                <input type="number" class="form-control" name="anio" id="anio" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN(para recuperar la informacíon vía API):</label>
                <input type="text" class="form-control" name="isbn" id="isbn" required>
                <small>ejemplos 0451526538, 9788845292613(señor de los anillos), 8478884459(harry potter)</small>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>