<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../config/config.php';

$bookController = new BookController($pdo);
$response=$bookController->getAll();
$mensaje='';$libros=[];
if ($response['success']) {
    $libros=$response['data'];
}else{
    $mensaje=$response['message'];
}

if (isset($_GET['rsp'])) {
    $decodedData = base64_decode($_GET['rsp']);
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($decodedData, 0, $iv_length);
    $ciphertext = substr($decodedData, $iv_length);
    $decryptedText = openssl_decrypt($ciphertext, 'aes-256-cbc', $secureKey, 0, $iv);
    $response=explode('-',htmlspecialchars($decryptedText));
    $mensaje=$response[0];
    if ($secureKey==$response[1]) {
        $mensaje=htmlspecialchars($mensaje); 
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmDelete(event, formId) {
            event.preventDefault();
            const confirmation = confirm("¿Estás seguro de que deseas eliminar este elemento?");
            if (confirmation) {
                document.getElementById(formId).submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Listado de Libros</h1>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        
        <a href="create.php" class="btn btn-primary mb-3">Dar de alta un libro</a>
        <a href="search.php" class="btn btn-primary mb-3">Buscar libro</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>ISBN</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($libros)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay libros disponibles.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($libro->id); ?></td>
                            <td><img src="<?php echo htmlspecialchars($libro->cover); ?>" /></td>
                            <td><?php echo htmlspecialchars($libro->title); ?></td>
                            <td><?php echo htmlspecialchars($libro->author); ?></td>
                            <td><?php echo htmlspecialchars($libro->anio); ?></td>
                            <td><?php echo htmlspecialchars($libro->isbn); ?></td>
                            <td><?php echo htmlspecialchars($libro->description); ?></td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <form action="update.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $libro->id; ?>">
                                            <input type="hidden" name="form_type" id="form_type" value="read_book">
                                            <button class="btn btn-warning btn-sm mb-sm-2" type="submit">editar</button>
                                        </form>
                                    </div>
                                    <div class="col-auto">
                                        <form action="delete.php" method="POST" id="deleteForm<?php echo $libro->id; ?>">
                                            <input type="hidden" name="id" value="<?php echo $libro->id; ?>">
                                            <input type="hidden" name="form_type" id="form_type" value="delete_book">
                                            <button class="btn btn-danger btn-sm" type="submit" onclick="confirmDelete(event, 'deleteForm<?php echo $libro->id; ?>')">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>