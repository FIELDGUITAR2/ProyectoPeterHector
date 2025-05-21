-- Crear base de datos y usarla
CREATE DATABASE IF NOT EXISTS Conjuntos;
USE Conjuntos;

-- Desactivar restricciones temporales para poblar
SET FOREIGN_KEY_CHECKS=0;

-- ============================
-- Crear tabla Admin
-- ============================
CREATE TABLE IF NOT EXISTS `Admin` (
  `idAdmin` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Propietario
-- ============================
CREATE TABLE IF NOT EXISTS `Propietario` (
  `idPropietario` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `fechaIngreso` DATE NOT NULL,
  PRIMARY KEY (`idPropietario`)
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Area (4 áreas predefinidas)
-- ============================
CREATE TABLE IF NOT EXISTS `Area` (
  `idArea` INT NOT NULL AUTO_INCREMENT,
  `metrosCuadrados` DOUBLE NOT NULL,
  PRIMARY KEY (`idArea`)
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Apartamento (usa tabla Area)
-- ============================
CREATE TABLE IF NOT EXISTS `Apartamento` (
  `idApartamento` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Area_idArea` INT NOT NULL,
  `Propietario_idPropietario` INT NOT NULL,
  PRIMARY KEY (`idApartamento`),
  INDEX `fk_Apartamento_Propietario1_idx` (`Propietario_idPropietario` ASC),
  INDEX `fk_Apartamento_Area1_idx` (`Area_idArea` ASC),
  CONSTRAINT `fk_Apartamento_Propietario1`
    FOREIGN KEY (`Propietario_idPropietario`)
    REFERENCES `Propietario` (`idPropietario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Apartamento_Area1`
    FOREIGN KEY (`Area_idArea`)
    REFERENCES `Area` (`idArea`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- ============================
-- Crear tabla EstadoPago
-- ============================
CREATE TABLE IF NOT EXISTS `EstadoPago` (
  `idEstadoPago` INT NOT NULL AUTO_INCREMENT,
  `valor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEstadoPago`)
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Cuenta
-- ============================
CREATE TABLE IF NOT EXISTS `Cuenta` (
  `idCuenta` INT NOT NULL AUTO_INCREMENT,
  `fechaLimite` DATE NOT NULL,
  `cantidad` DOUBLE NOT NULL,
  `saldoAnterior` DOUBLE NOT NULL,
  `Admin_idAdmin` INT NOT NULL,
  `Apartamento_idApartamento` INT NOT NULL,
  `EstadoPago_idEstadoPago` INT NOT NULL,
  PRIMARY KEY (`idCuenta`),
  INDEX `fk_Cuenta_Admin1_idx` (`Admin_idAdmin` ASC),
  INDEX `fk_Cuenta_Apartamento1_idx` (`Apartamento_idApartamento` ASC),
  INDEX `fk_Cuenta_EstadoPago1_idx` (`EstadoPago_idEstadoPago` ASC),
  CONSTRAINT `fk_Cuenta_Admin1`
    FOREIGN KEY (`Admin_idAdmin`)
    REFERENCES `Admin` (`idAdmin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuenta_Apartamento1`
    FOREIGN KEY (`Apartamento_idApartamento`)
    REFERENCES `Apartamento` (`idApartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuenta_EstadoPago1`
    FOREIGN KEY (`EstadoPago_idEstadoPago`)
    REFERENCES `EstadoPago` (`idEstadoPago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Pagos
-- ============================
CREATE TABLE IF NOT EXISTS `Pagos` (
  `idPagos` INT NOT NULL AUTO_INCREMENT,
  `fechaPago` DATE NOT NULL,
  `Cuenta_idCuenta` INT NOT NULL,
  PRIMARY KEY (`idPagos`),
  INDEX `fk_Pagos_Cuenta1_idx` (`Cuenta_idCuenta` ASC),
  CONSTRAINT `fk_Pagos_Cuenta1`
    FOREIGN KEY (`Cuenta_idCuenta`)
    REFERENCES `Cuenta` (`idCuenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- ============================
-- Insertar datos en Admin
-- ============================
INSERT INTO Admin (idAdmin, nombre, apellido, clave)
VALUES 
(1001, 'Samir', 'Gonzalez', '123'),
(1002, 'Cristian', 'Barrera', '456');

-- ============================
-- Insertar datos en Propietario
-- ============================
INSERT INTO Propietario (idPropietario, nombre, apellido, clave, fechaIngreso)
VALUES
(1, 'Eduard', 'Quintero', 'clave1', '2022-02-10'),
(2, 'Andrés Felipe', 'Rodriguez Herrera', 'clave2', '2021-05-20'),
(3, 'Luisa', 'Parra', 'clave3', '2023-01-15'),
(4, 'Cristian Daniel', 'Feo Patarroyo', 'clave4', '2020-11-05'),
(5, 'Daniel', 'Cruz', 'clave5', '2019-09-13'),
(6, 'Camila', 'Ríos', 'clave6', '2020-03-01'),
(7, 'Mateo', 'Gómez', 'clave7', '2021-06-21'),
(8, 'Valentina', 'Martínez', 'clave8', '2022-08-17'),
(9, 'Sebastián', 'Torres', 'clave9', '2023-03-09'),
(10, 'Isabela', 'López', 'clave10', '2021-01-01'),
(11, 'Juan Pablo', 'Ramírez', 'clave11', '2022-09-12'),
(12, 'Sara', 'Herrera', 'clave12', '2021-04-25'),
(13, 'Tomás', 'Jiménez', 'clave13', '2023-07-30'),
(14, 'Laura', 'Mejía', 'clave14', '2020-12-05'),
(15, 'Emilio', 'Navarro', 'clave15', '2022-11-11');

-- ============================
-- Insertar áreas disponibles
-- ============================
INSERT INTO Area (metrosCuadrados)
VALUES (60), (70), (80), (90);

-- ============================
-- Insertar apartamentos (usando IDs de área 1–4)
-- ============================
INSERT INTO Apartamento (nombre, Area_idArea, Propietario_idPropietario)
VALUES
('101', 1, 1),
('102', 2, 2),
('103', 3, 3),
('104', 4, 4),
('105', 1, 5),
('106', 2, 6),
('107', 3, 7),
('108', 4, 8),
('109', 1, 9),
('110', 2, 10),
('111', 3, 11),
('112', 4, 12),
('113', 1, 13),
('114', 2, 14),
('115', 3, 15);

-- ============================
-- Insertar estados de pago
-- ============================
INSERT INTO EstadoPago (valor)
VALUES
('PAGADO'),     -- id = 1
('ATRASADO');   -- id = 2

-- ============================
-- Insertar cuentas
-- ============================
INSERT INTO Cuenta (fechaLimite, cantidad, saldoAnterior, Admin_idAdmin, Apartamento_idApartamento, EstadoPago_idEstadoPago)
VALUES
('2025-04-30', 250000, 0, 1001, 1, 1),
('2025-04-30', 280000, 0, 1002, 2, 1),
('2025-04-30', 260000, 80000, 1001, 3, 2),
('2025-04-30', 300000, 150000, 1002, 4, 2),
('2025-04-30', 270000, 0, 1001, 5, 1),
('2025-04-30', 240000, 0, 1001, 6, 1),
('2025-04-30', 260000, 50000, 1002, 7, 2),
('2025-04-30', 250000, 0, 1002, 8, 1),
('2025-04-30', 265000, 65000, 1001, 9, 2),
('2025-04-30', 275000, 0, 1002, 10, 1),
('2025-04-30', 280000, 0, 1001, 11, 1),
('2025-04-30', 290000, 90000, 1002, 12, 2),
('2025-04-30', 255000, 0, 1001, 13, 1),
('2025-04-30', 300000, 120000, 1002, 14, 2),
('2025-04-30', 260000, 0, 1001, 15, 1);

-- ============================
-- Insertar pagos (solo para cuentas con estado PAGADO)
-- ============================
INSERT INTO Pagos (fechaPago, Cuenta_idCuenta)
VALUES
('2025-04-29', 1),
('2025-04-29', 2),
('2025-04-28', 5),
('2025-04-28', 6),
('2025-04-29', 8),
('2025-04-28', 10),
('2025-04-29', 11),
('2025-04-30', 13),
('2025-04-28', 15);

-- Reactivar validación de claves foráneas
SET FOREIGN_KEY_CHECKS=1;
