CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    anio INT NOT NULL,
    isbn VARCHAR(255) NOT NULL,
    cover VARCHAR(255) NOT NULL,
    description TEXT,
    INDEX idx_title (title),
    INDEX idx_author (author),
    INDEX idx_anio (anio),
    INDEX idx_isbn (isbn)
);