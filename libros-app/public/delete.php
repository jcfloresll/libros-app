<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../config/config.php';

$mensaje = ''; $objLibro=null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'delete_book' && isset($_POST['id'])) {
        $id = htmlspecialchars(trim($_POST['id']), ENT_QUOTES, 'UTF-8');
        $bookController = new BookController($pdo);
        $response=$bookController->delete($id);

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
            $bookController = new BookController($pdo);
            $response=$bookController->read($id);
            if ($response['success']) {
                $objLibro=$response['data'];
            }
        }

    } else {
        $mensaje = 'datos incorrectos';
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar libro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Actualizar Libro</h1>
        <a href="index.php" class="btn btn-primary mb-3">Volver al listado</a>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <?php if (!empty($objLibro)): ?>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($objLibro->title); ?>" required>
                </div>

                <div class="form-group">
                    <label for="author">Autor:</label>
                    <input type="text" class="form-control" name="author" id="author" value="<?php echo htmlspecialchars($objLibro->author); ?>" required>
                </div>

                <div class="form-group">
                    <label for="anio">Año:</label>
                    <input type="number" class="form-control" name="anio" id="anio" value="<?php echo htmlspecialchars($objLibro->anio); ?>" required>
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN(para recuperar la informacíon vía API):</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" value="<?php echo htmlspecialchars($objLibro->isbn); ?>" required>
                    <small>ejemplo 0451526538</small>
                </div>
                <input type="hidden" name="form_type" id="form_type" value="update_book">
                <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($objLibro->id); ?>">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        <?php endif; ?>
        
        
        
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>