# libros-app v1.0

Aplicación que gestiona una lista de libros, permite, crear, leer, actualizar y borrar, como complemento
realiza consultas a la API de Open Library, para actualizar el contenido del libro como la descripción(en algunos casos no hay este dato en la API) y 
la foto de la portada del libro.
Tambien permite realizar busquedas por titulo o author.


## Tabla de Contenidos
- [Características](#características)
- [Instalación](#instalación)
- [Repositorio](#Repositorio)
- [webDesarrollo](#webDesarrollo)
- [RequisitosTécnicos](#RequisitosTécnicos)


## Características
- Lista de libros que permite crear, actualizar, borrar y leer.
- Búsqueda de libros por título y autor.
- Interfaz de usuario intuitiva.

## Instalación

Para el correcto funcionamiento:
1) Ejecutar en un gestor de base de datos(MySQL por ejemplo) el siguiente archivo config/sql.sql para crear la tabla que almacenara los datos.
2) Cambiar los datos de conexión a la base de datos en el siguiente archivo config/database.php


# Repositorio
git https://github.com/jcfloresll/libros-app

# webDesarrollo
https://appbooks.ansystem.es/


# RequisitosTécnicos
1) PHP nativo, implementado.
2) Conexión con base de datos, MySQL, implementado.
3) SOLID, implementado.
4) Diseño, basico usando Bootstrap.
5) Manejo de errores, implementado.
6) Loggin básico, implementado.
7) Seguridad básico imeplementado.
8) Optimización de la Base de Datos, creación de índices, implementado.
9) Se crea la Clase OpenLibraryApiClient para la gestión de conexión con la API de Open Library.
