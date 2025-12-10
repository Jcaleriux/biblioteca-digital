create database biblioteca;

use biblioteca;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','lector') DEFAULT 'lector'
);

-- Tabla de libros
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    isbn VARCHAR(20) NOT NULL,
    categoria VARCHAR(50),
    ano INT,
    descripcion TEXT,
    imagen VARCHAR(255),
    archivo VARCHAR(255) NULL,
    disponible TINYINT(1) DEFAULT 1
);

-- Tabla de préstamos
CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_libro INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    estado ENUM('Activo','Devuelto') DEFAULT 'Activo',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_libro) REFERENCES libros(id)
);

-- select * from usuarios; -- consulta de tabla de usuarios
-- select * FROM libros; --consulta de tabla de libros
-- select * FROM prestamos; -- consulta de tabla de prestamos
-- UPDATE `biblioteca`.`usuarios` SET `correo` = 'pepe@gmail.com' WHERE (`id` = '3'); -- consulta para actualizar info de usuario
-- DELETE FROM `biblioteca`.`libros` WHERE (`id` = '4'); -- Consulta para eliminar de BD biblioteca, tabla "libros" ID "4"
