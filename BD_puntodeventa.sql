-- Creación de la base de datos
CREATE DATABASE PuntoVentaContabilidad;
GO
USE PuntoVentaContabilidad;
GO

-- Tabla de usuarios (para el inicio de sesión)
CREATE TABLE usuarios (
    id INT PRIMARY KEY IDENTITY(1,1),
    nombre_usuario VARCHAR(100) UNIQUE,
    correo VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    rol VARCHAR(50) CHECK (rol IN ('admin', 'vendedor', 'contador')),  -- Roles específicos para el sistema
    estado CHAR(1) DEFAULT 'A' CHECK (estado IN ('A', 'I'))  -- Estado: A (activo), I (inactivo)
);
GO



-- Tabla de clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(100),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    sexo CHAR(1) CHECK (sexo IN ('M', 'F')),  -- Reemplazo de ENUM por CHECK
    NIT VARCHAR(20),
    CUI VARCHAR(20),
    seguro_medico VARCHAR(50),
    numero_poliza VARCHAR(50)
);
GO

-- Tabla de categorías
CREATE TABLE categorias (
    id INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(100)
);
GO


-- Tabla de productos
CREATE TABLE productos (
    id INT PRIMARY KEY IDENTITY(1,1),
    codigo_producto VARCHAR(20) UNIQUE,
    descripcion VARCHAR(255),
    precio_unitario DECIMAL(10, 2),
    impuestos DECIMAL(5, 2),
    numero_serie VARCHAR(50),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);
GO


-- Tabla de ventas
CREATE TABLE ventas (
    id INT PRIMARY KEY IDENTITY(1,1),
    fecha DATETIME,
    forma_pago VARCHAR(20) CHECK (forma_pago IN ('efectivo', 'tarjeta', 'transferencia')),  -- Reemplazo de ENUM por CHECK
    numero_factura VARCHAR(20),
    descuento DECIMAL(5, 2),
    total DECIMAL(10, 2),
    cliente_id INT,
    cuenta_corriente DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);
GO

-- Detalle de ventas (productos vendidos en cada venta)
CREATE TABLE detalle_ventas (
    id INT PRIMARY KEY IDENTITY(1,1),
    venta_id INT,
    producto_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
GO

-- Tabla de devoluciones
CREATE TABLE devoluciones (
    id INT PRIMARY KEY IDENTITY(1,1),
    fecha DATE,
    motivo VARCHAR(255),
    venta_id INT,
    producto_id INT,
    cantidad INT,
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
GO

-- Tabla de bancos
CREATE TABLE bancos (
    id INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(100)
);
GO

-- Tabla de pagos
CREATE TABLE pagos (
    id INT PRIMARY KEY IDENTITY(1,1),
    fecha DATE,
    forma_pago VARCHAR(20) CHECK (forma_pago IN ('efectivo', 'tarjeta', 'transferencia')),  -- Reemplazo de ENUM por CHECK
    monto DECIMAL(10, 2),
    numero_referencia VARCHAR(50),
    banco_id INT,
    cliente_id INT,
    FOREIGN KEY (banco_id) REFERENCES bancos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);
GO



-- Tabla de inventarios
CREATE TABLE inventarios (
    id INT PRIMARY KEY IDENTITY(1,1),
    producto_id INT,
    cantidad_inicial INT,
    cantidad_vendida INT,
    cantidad_recibida INT,
    cantidad_existente INT,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
GO

-- Tabla de proveedores
CREATE TABLE proveedores (
    id INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(100),
    NIT VARCHAR(20),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100)
);
GO

-- Tabla de compras (para el sistema de contabilidad)
CREATE TABLE compras (
    id INT PRIMARY KEY IDENTITY(1,1),
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
GO



-- Tabla de cuentas por cobrar
CREATE TABLE cuentas_por_cobrar (
    id INT PRIMARY KEY IDENTITY(1,1),
    cliente_id INT,
    saldo DECIMAL(10, 2),
    fecha_vencimiento DATE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);
GO

-- Tabla de cuentas por pagar
CREATE TABLE cuentas_por_pagar (
    id INT PRIMARY KEY IDENTITY(1,1),
    proveedor_id INT,
    saldo DECIMAL(10, 2),
    fecha_vencimiento DATE,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);
GO


-- Insertar registros en la tabla de usuarios
INSERT INTO usuarios (nombre_usuario, correo, contraseña, rol, estado)
VALUES 
('admin01', 'admin@punto.com', 'admin123', 'admin', 'A'),
('vendedor01', 'vendedor@punto.com', 'vendedor123', 'vendedor', 'A'),
('contador01', 'contador@punto.com', 'contador123', 'contador', 'A');
GO

-- Insertar registros en la tabla de clientes
INSERT INTO clientes (nombre, direccion, telefono, correo, sexo, NIT, CUI, seguro_medico, numero_poliza)
VALUES 
('Juan Perez', '123 Calle Principal', '555-1234', 'juan@correo.com', 'M', '123456789', '987654321', 'Medicare', 'POL12345'),
('Maria Lopez', '456 Calle Secundaria', '555-5678', 'maria@correo.com', 'F', '987654321', '123456789', 'Blue Cross', 'POL67890');
GO

-- Insertar registros en la tabla de categorías
INSERT INTO categorias (nombre)
VALUES 
('Electrónica'),
('Hogar'),
('Ropa');
GO

-- Insertar registros en la tabla de productos
INSERT INTO productos (codigo_producto, descripcion, precio_unitario, impuestos, numero_serie, categoria_id)
VALUES 
('P001', 'Televisor 42"', 350.00, 15.00, 'TV12345', 1),
('P002', 'Lavadora', 500.00, 10.00, 'LV54321', 2),
('P003', 'Camisa', 25.00, 5.00, NULL, 3);
GO

-- Insertar registros en la tabla de ventas
INSERT INTO ventas (fecha, forma_pago, numero_factura, descuento, total, cliente_id, cuenta_corriente)
VALUES 
(GETDATE(), 'efectivo', 'F001', 0.00, 350.00, 1, 0.00),
(GETDATE(), 'tarjeta', 'F002', 50.00, 450.00, 2, 50.00);
GO

-- Insertar registros en la tabla de detalle_ventas
INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario)
VALUES 
(1, 1, 1, 350.00),
(2, 2, 1, 500.00);
GO

-- Insertar registros en la tabla de devoluciones
INSERT INTO devoluciones (fecha, motivo, venta_id, producto_id, cantidad)
VALUES 
(GETDATE(), 'Producto defectuoso', 1, 1, 1);
GO

-- Insertar registros en la tabla de bancos
INSERT INTO bancos (nombre)
VALUES 
('Banco Nacional'),
('Banco Internacional');
GO

-- Insertar registros en la tabla de pagos
INSERT INTO pagos (fecha, forma_pago, monto, numero_referencia, banco_id, cliente_id)
VALUES 
(GETDATE(), 'tarjeta', 350.00, 'REF001', 1, 1),
(GETDATE(), 'efectivo', 450.00, 'REF002', 2, 2);
GO

-- Insertar registros en la tabla de inventarios
INSERT INTO inventarios (producto_id, cantidad_inicial, cantidad_vendida, cantidad_recibida, cantidad_existente)
VALUES 
(1, 100, 1, 0, 99),
(2, 50, 1, 0, 49);
GO

-- Insertar registros en la tabla de proveedores
INSERT INTO proveedores (nombre, NIT, direccion, telefono, correo)
VALUES 
('Proveedor 1', '123456789', '123 Calle Comercio', '555-9876', 'prov1@comercio.com'),
('Proveedor 2', '987654321', '456 Calle Industrial', '555-6789', 'prov2@comercio.com');
GO

-- Insertar registros en la tabla de compras
INSERT INTO compras (fecha, proveedor_id, numero_factura, producto_id, cantidad, precio_unitario, impuestos, total)
VALUES 
(GETDATE(), 1, 'C001', 1, 10, 300.00, 15.00, 3150.00),
(GETDATE(), 2, 'C002', 2, 5, 450.00, 10.00, 2475.00);
GO

-- Insertar registros en la tabla de cuentas por cobrar
INSERT INTO cuentas_por_cobrar (cliente_id, saldo, fecha_vencimiento)
VALUES 
(1, 100.00, DATEADD(DAY, 30, GETDATE())),
(2, 200.00, DATEADD(DAY, 45, GETDATE()));
GO

-- Insertar registros en la tabla de cuentas por pagar
INSERT INTO cuentas_por_pagar (proveedor_id, saldo, fecha_vencimiento)
VALUES 
(1, 500.00, DATEADD(DAY, 60, GETDATE())),
(2, 750.00, DATEADD(DAY, 90, GETDATE()));
GO


SELECT * FROM usuarios;
GO

SELECT * FROM clientes;
GO

SELECT * FROM categorias;
GO

SELECT * FROM productos;
GO

SELECT * FROM ventas;
GO

SELECT * FROM detalle_ventas;
GO

SELECT * FROM devoluciones;
GO

SELECT * FROM bancos;
GO

SELECT * FROM pagos;
GO

SELECT * FROM inventarios;
GO

SELECT * FROM compras;
GO

SELECT * FROM cuentas_por_cobrar;
GO



