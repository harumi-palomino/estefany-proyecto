CREATE DATABASE IF NOT EXISTS tienda_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tienda_db;

DROP TABLE IF EXISTS imagenes;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;

CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL
);

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  categoria_id INT NOT NULL,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE imagenes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  url VARCHAR(255) NOT NULL,
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

INSERT INTO categorias (nombre) VALUES
  ('Electrónica'),
  ('Computación'),
  ('Accesorios');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES
  ('Auriculares inalámbricos', 'Disfruta de un sonido de alta calidad con estos auriculares inalámbricos. Diseño ergonómico y batería de larga duración.', 49.99, 25, 1),
  ('Reloj inteligente', 'Controla tu salud, tus pasos y recibe las notificaciones de tu celular directamente en la muñeca.', 79.99, 18, 1),
  ('Smartphone', 'Pantalla amplia, cámara de alta resolución y batería para todo el día. Conecta, captura y disfruta.', 499.99, 12, 1),
  ('Laptop 15.6"', 'Rendimiento y portabilidad en un solo equipo. Ideal para estudiar, trabajar y navegar.', 699.99, 7, 2),
  ('Teclado mecánico', 'Teclado mecánico con retroiluminación y switches de respuesta rápida.', 59.90, 30, 2),
  ('Mochila para laptop', 'Mochila resistente al agua con compartimento acolchado para equipos de hasta 15.6 pulgadas.', 39.90, 40, 3),
  ('Cargador portátil 10000 mAh', 'Batería externa compacta con dos puertos USB para cargar tus dispositivos en cualquier lugar.', 24.50, 50, 3);

INSERT INTO imagenes (producto_id, url) VALUES
  (1, 'https://placehold.co/600x600/png?text=Auriculares+1'),
  (1, 'https://placehold.co/600x600/png?text=Auriculares+2'),
  (2, 'https://placehold.co/600x600/png?text=Reloj+1'),
  (2, 'https://placehold.co/600x600/png?text=Reloj+2'),
  (3, 'https://placehold.co/600x600/png?text=Smartphone+1'),
  (3, 'https://placehold.co/600x600/png?text=Smartphone+2'),
  (4, 'https://placehold.co/600x600/png?text=Laptop+1'),
  (5, 'https://placehold.co/600x600/png?text=Teclado+1'),
  (6, 'https://placehold.co/600x600/png?text=Mochila+1'),
  (7, 'https://placehold.co/600x600/png?text=Cargador+1');
