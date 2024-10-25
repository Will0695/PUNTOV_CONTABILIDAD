-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS PuntoVentaContabilidad;
USE PuntoVentaContabilidad;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(100) UNIQUE,
    correo VARCHAR(100) UNIQUE,
    contrasena VARCHAR(255),
    rol VARCHAR(50),  -- Aplicar la lógica de roles en PHP
    estado CHAR(1) DEFAULT 'A'  -- Aplicar la lógica de estado en PHP
);

-- Tabla de clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    sexo CHAR(1),  -- Aplicar la lógica de sexo en PHP
    NIT VARCHAR(20),
    CUI VARCHAR(20),
    seguro_medico VARCHAR(50),
    numero_poliza VARCHAR(50)
);

-- Tabla de categorías
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);

-- Tabla de productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codigo_producto VARCHAR(20) UNIQUE,
    descripcion VARCHAR(255),
    precio_unitario DECIMAL(10, 2),
    impuestos DECIMAL(5, 2),
    numero_serie VARCHAR(50),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabla de ventas
CREATE TABLE ventas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATETIME,
    forma_pago VARCHAR(20),  -- Aplicar la lógica en PHP
    numero_factura VARCHAR(20),
    descuento DECIMAL(5, 2),
    total DECIMAL(10, 2),
    cliente_id INT,
    cuenta_corriente DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Detalle de ventas
CREATE TABLE detalle_ventas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    venta_id INT,
    producto_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla de devoluciones
CREATE TABLE devoluciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    motivo VARCHAR(255),
    venta_id INT,
    producto_id INT,
    cantidad INT,
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla de bancos
CREATE TABLE bancos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);

-- Tabla de pagos
CREATE TABLE pagos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    forma_pago VARCHAR(20),  -- Aplicar la lógica en PHP
    monto DECIMAL(10, 2),
    numero_referencia VARCHAR(50),
    banco_id INT,
    cliente_id INT,
    FOREIGN KEY (banco_id) REFERENCES bancos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabla de inventarios
CREATE TABLE inventarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    producto_id INT,
    cantidad_inicial INT,
    cantidad_vendida INT,
    cantidad_recibida INT,
    cantidad_existente INT,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla de proveedores
CREATE TABLE proveedores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    NIT VARCHAR(20),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

-- Tabla de compras
CREATE TABLE compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    proveedor_id INT,
    numero_factura VARCHAR(20),
    producto_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    impuestos DECIMAL(5, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla de cuentas por cobrar
CREATE TABLE cuentas_por_cobrar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT,
    saldo DECIMAL(10, 2),
    fecha_vencimiento DATE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabla de cuentas por pagar
CREATE TABLE cuentas_por_pagar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proveedor_id INT,
    saldo DECIMAL(10, 2),
    fecha_vencimiento DATE,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);

-- Insertar registros en la tabla de usuarios
INSERT INTO usuarios (nombre_usuario, correo, contrasena, rol, estado)
VALUES 
('admin01', 'admin@punto.com', 'admin123', 'admin', 'A'),
('vendedor01', 'vendedor@punto.com', 'vendedor123', 'vendedor', 'A'),
('contador01', 'contador@punto.com', 'contador123', 'contador', 'A');

-- Insertar registros en la tabla de clientes
INSERT INTO clientes (nombre, direccion, telefono, correo, sexo, NIT, CUI, seguro_medico, numero_poliza)
VALUES 
('Juan Perez', '123 Calle Principal', '555-1234', 'juan@correo.com', 'M', '123456789', '987654321', 'Medicare', 'POL12345'),
('Maria Lopez', '456 Calle Secundaria', '555-5678', 'maria@correo.com', 'F', '987654321', '123456789', 'Blue Cross', 'POL67890');

-- Insertar registros en la tabla de categorías
INSERT INTO categorias (nombre)
VALUES 
('Electrónica'),
('Hogar'),
('Ropa');

-- Insertar registros en la tabla de productos
INSERT INTO productos (codigo_producto, descripcion, precio_unitario, impuestos, numero_serie, categoria_id)
VALUES 
('P001', 'Televisor 42"', 350.00, 15.00, 'TV12345', 1),
('P002', 'Lavadora', 500.00, 10.00, 'LV54321', 2),
('P003', 'Camisa', 25.00, 5.00, NULL, 3);
