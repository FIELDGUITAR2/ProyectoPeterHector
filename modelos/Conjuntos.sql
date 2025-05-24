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
  `telefono` VARCHAR(20) NOT NULL,
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
  `telefono` VARCHAR(20) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `fechaIngreso` DATE NOT NULL,
  PRIMARY KEY (`idPropietario`)
) ENGINE = InnoDB;

-- ============================
-- Crear tabla Area
-- ============================
CREATE TABLE IF NOT EXISTS `Area` (
  `idArea` INT NOT NULL AUTO_INCREMENT,
  `metrosCuadrados` DOUBLE NOT NULL,
  `valorArriendo` INT NOT NULL,
  PRIMARY KEY (`idArea`)
) ENGINE = InnoDB;


-- ============================
-- Crear tabla Apartamento
-- ============================
CREATE TABLE IF NOT EXISTS `Apartamento` (
  `idApartamento` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Area_idArea` INT NOT NULL,
  `Propietario_idPropietario` INT NULL,
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

INSERT INTO Admin (idAdmin, nombre, apellido, telefono, clave)
VALUES 
(1001, 'Samir', 'Gonzalez', '3001234567', '123'),
(1002, 'Cristian', 'Barrera', '3009876543', '456');


INSERT INTO Propietario (idPropietario, nombre, apellido, telefono, clave, fechaIngreso)
VALUES
(1, 'Eduard', 'Quintero', '3010000001', 'clave1', '2022-02-10'),
(2, 'Andrés Felipe', 'Rodriguez Herrera', '3010000002', 'clave2', '2021-05-20'),
(3, 'Luisa', 'Parra', '3010000003', 'clave3', '2023-01-15'),
(4, 'Cristian Daniel', 'Feo Patarroyo', '3010000004', 'clave4', '2020-11-05'),
(5, 'Daniel', 'Cruz', '3010000005', 'clave5', '2019-09-13'),
(6, 'Camila', 'Ríos', '3010000006', 'clave6', '2020-03-01'),
(7, 'Mateo', 'Gómez', '3010000007', 'clave7', '2021-06-21'),
(8, 'Valentina', 'Martínez', '3010000008', 'clave8', '2022-08-17'),
(9, 'Sebastián', 'Torres', '3010000009', 'clave9', '2023-03-09'),
(10, 'Isabela', 'López', '3010000010', 'clave10', '2021-01-01');


INSERT INTO Area (metrosCuadrados, valorArriendo)
VALUES 
  (60, 500000),
  (70, 600000),
  (80, 700000),
  (90, 800000);



INSERT INTO Apartamento (nombre, Area_idArea, Propietario_idPropietario)
VALUES
('101', 1, 1),
('102', 2, 2),
('103', 3, 3),
('104', 4, 4),
('105', 1, 5),
('201', 2, 6),
('202', 3, 7),
('203', 4, 8),
('204', 1, 9),
('205', 2, 10),
('106', 3, 1),   -- Eduard tiene otro apartamento
('207', 4, 2),   -- Andrés Felipe también
('107', 1, 3),   -- Luisa también
('108', 2, NULL), -- vacío
('208', 3, NULL), -- vacío
('206', 4, 4),   -- Cristian Daniel tiene otro
('209', 1, 5),   -- Daniel también
('109', 2, 6),   -- Camila también
('110', 3, NULL), -- vacío
('210', 4, NULL); -- vacío


INSERT INTO EstadoPago (valor)
VALUES
('PAGADO'),     -- id = 1
('ATRASADO');   -- id = 2


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

INSERT INTO EstadoPago (valor)
VALUES ('PENDIENTE'); -- id = 3


DELETE FROM Cuenta WHERE idCuenta >= 16;