<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../config/config.php';

$libros=[]; $mensaje='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $searchTerm = htmlspecialchars(trim($_POST['searchTerm']), ENT_QUOTES, 'UTF-8');
    $bookController = new BookController($pdo);
    $response=$bookController->getSearchByTerm($searchTerm);
    if ($response['success']) {
          $libros=$response['data'];
    }else{
        $mensaje=$response['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Libros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Buscar Libros</h1>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary mb-3">Volver al listado de libros</a>

            <div class="col-xs-12">
                <form action="search.php" method="POST">
                    <div class="form-group">
                        <label for="titulo">Buscar por titulo</label>
                        <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="Busca por título o autor" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <br /><br />

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

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
                            <td colspan="6" class="text-center">No hay libros disponibles con este termino de busqueda.</td>
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
        <?php endif; ?>    
       
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>