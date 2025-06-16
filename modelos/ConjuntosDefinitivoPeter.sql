-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2025 at 05:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Conjuntos`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `idAdmin` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `Correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`idAdmin`, `nombre`, `apellido`, `telefono`, `clave`, `Correo`) VALUES
(1001, 'Samir', 'Gonzalez', '3001234567', '123', ''),
(1002, 'Cristian', 'Barrera', '3009876543', '456', '');

-- --------------------------------------------------------

--
-- Table structure for table `Apartamento`
--

CREATE TABLE `Apartamento` (
  `idApartamento` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `Area_idArea` int(11) NOT NULL,
  `Propietario_idPropietario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Apartamento`
--

INSERT INTO `Apartamento` (`idApartamento`, `nombre`, `Area_idArea`, `Propietario_idPropietario`) VALUES
(1, '101', 1, 1),
(2, '102', 2, 2),
(3, '103', 3, 3),
(4, '104', 4, 4),
(5, '105', 1, 5),
(6, '106', 2, 6),
(7, '107', 3, 7),
(8, '108', 4, 8),
(9, '109', 1, 9),
(10, '110', 2, 10),
(11, '111', 3, 1),
(12, '112', 4, 2),
(13, '113', 1, 3),
(14, '114', 2, NULL),
(15, '115', 3, NULL),
(16, '116', 4, 4),
(17, '117', 1, 5),
(18, '118', 2, 6),
(19, '119', 3, NULL),
(20, '120', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Area`
--

CREATE TABLE `Area` (
  `idArea` int(11) NOT NULL,
  `metrosCuadrados` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Area`
--

INSERT INTO `Area` (`idArea`, `metrosCuadrados`) VALUES
(1, 60),
(2, 70),
(3, 80),
(4, 90);

-- --------------------------------------------------------

--
-- Table structure for table `Cuenta`
--

CREATE TABLE `Cuenta` (
  `idCuenta` int(11) NOT NULL,
  `fechaLimite` date NOT NULL,
  `cantidad` double NOT NULL,
  `saldoAnterior` double NOT NULL,
  `Admin_idAdmin` int(11) NOT NULL,
  `Apartamento_idApartamento` int(11) NOT NULL,
  `EstadoPago_idEstadoPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Cuenta`
--

INSERT INTO `Cuenta` (`idCuenta`, `fechaLimite`, `cantidad`, `saldoAnterior`, `Admin_idAdmin`, `Apartamento_idApartamento`, `EstadoPago_idEstadoPago`) VALUES
(1, '2025-04-30', 250000, 0, 1001, 1, 1),
(2, '2025-04-30', 280000, 0, 1002, 2, 1),
(3, '2025-04-30', 260000, 80000, 1001, 3, 2),
(4, '2025-04-30', 300000, 150000, 1002, 4, 2),
(5, '2025-04-30', 270000, 0, 1001, 5, 1),
(6, '2025-04-30', 240000, 0, 1001, 6, 1),
(7, '2025-04-30', 260000, 50000, 1002, 7, 2),
(8, '2025-04-30', 250000, 0, 1002, 8, 1),
(9, '2025-04-30', 265000, 65000, 1001, 9, 2),
(10, '2025-04-30', 275000, 0, 1002, 10, 1),
(11, '2025-04-30', 280000, 0, 1001, 11, 1),
(12, '2025-04-30', 290000, 90000, 1002, 12, 2),
(13, '2025-04-30', 255000, 0, 1001, 13, 1),
(14, '2025-04-30', 300000, 120000, 1002, 14, 2),
(15, '2025-04-30', 260000, 0, 1001, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `EstadoPago`
--

CREATE TABLE `EstadoPago` (
  `idEstadoPago` int(11) NOT NULL,
  `valor` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `EstadoPago`
--

INSERT INTO `EstadoPago` (`idEstadoPago`, `valor`) VALUES
(1, 'PAGADO'),
(2, 'ATRASADO');

-- --------------------------------------------------------

--
-- Table structure for table `Pagos`
--

CREATE TABLE `Pagos` (
  `idPagos` int(11) NOT NULL,
  `fechaPago` date NOT NULL,
  `Cuenta_idCuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Pagos`
--

INSERT INTO `Pagos` (`idPagos`, `fechaPago`, `Cuenta_idCuenta`) VALUES
(1, '2025-04-29', 1),
(2, '2025-04-29', 2),
(3, '2025-04-28', 5),
(4, '2025-04-28', 6),
(5, '2025-04-29', 8),
(6, '2025-04-28', 10),
(7, '2025-04-29', 11),
(8, '2025-04-30', 13),
(9, '2025-04-28', 15);

-- --------------------------------------------------------

--
-- Table structure for table `Propietario`
--

CREATE TABLE `Propietario` (
  `idPropietario` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `fechaIngreso` date NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Propietario`
--

INSERT INTO `Propietario` (`idPropietario`, `nombre`, `apellido`, `telefono`, `clave`, `fechaIngreso`, `correo`) VALUES
(1, 'Eduard', 'Quintero', '3010000001', 'clave1', '2022-02-10', ''),
(2, 'Andrés Felipe', 'Rodriguez Herrera', '3010000002', 'clave2', '2021-05-20', ''),
(3, 'luisa', 'Parra', '3010000003', 'clave3', '2023-01-15', ''),
(4, 'Cristian Daniel', 'Feo Patarroyo', '3010000004', 'clave4', '2020-11-05', ''),
(5, 'Daniel', 'Cruz', '3010000005', 'clave5', '2019-09-13', ''),
(6, 'Camila', 'Ríos', '3010000006', 'clave6', '2020-03-01', ''),
(7, 'Mateo', 'Gómez', '3010000007', 'clave7', '2021-06-21', ''),
(8, 'Valentina', 'Martínez', '3010000008', 'clave8', '2022-08-17', ''),
(9, 'Sebastián', 'Torres', '3010000009', 'clave9', '2023-03-09', ''),
(10, 'Isabela', 'López', '3010000010', 'clave10', '2021-01-01', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `Apartamento`
--
ALTER TABLE `Apartamento`
  ADD PRIMARY KEY (`idApartamento`),
  ADD KEY `fk_Apartamento_Propietario1_idx` (`Propietario_idPropietario`),
  ADD KEY `fk_Apartamento_Area1_idx` (`Area_idArea`);

--
-- Indexes for table `Area`
--
ALTER TABLE `Area`
  ADD PRIMARY KEY (`idArea`);

--
-- Indexes for table `Cuenta`
--
ALTER TABLE `Cuenta`
  ADD PRIMARY KEY (`idCuenta`),
  ADD KEY `fk_Cuenta_Admin1_idx` (`Admin_idAdmin`),
  ADD KEY `fk_Cuenta_Apartamento1_idx` (`Apartamento_idApartamento`),
  ADD KEY `fk_Cuenta_EstadoPago1_idx` (`EstadoPago_idEstadoPago`);

--
-- Indexes for table `EstadoPago`
--
ALTER TABLE `EstadoPago`
  ADD PRIMARY KEY (`idEstadoPago`);

--
-- Indexes for table `Pagos`
--
ALTER TABLE `Pagos`
  ADD PRIMARY KEY (`idPagos`),
  ADD KEY `fk_Pagos_Cuenta1_idx` (`Cuenta_idCuenta`);

--
-- Indexes for table `Propietario`
--
ALTER TABLE `Propietario`
  ADD PRIMARY KEY (`idPropietario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Apartamento`
--
ALTER TABLE `Apartamento`
  MODIFY `idApartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Area`
--
ALTER TABLE `Area`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Cuenta`
--
ALTER TABLE `Cuenta`
  MODIFY `idCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `EstadoPago`
--
ALTER TABLE `EstadoPago`
  MODIFY `idEstadoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Pagos`
--
ALTER TABLE `Pagos`
  MODIFY `idPagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Apartamento`
--
ALTER TABLE `Apartamento`
  ADD CONSTRAINT `fk_Apartamento_Area1` FOREIGN KEY (`Area_idArea`) REFERENCES `Area` (`idArea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Apartamento_Propietario1` FOREIGN KEY (`Propietario_idPropietario`) REFERENCES `Propietario` (`idPropietario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Cuenta`
--
ALTER TABLE `Cuenta`
  ADD CONSTRAINT `fk_Cuenta_Admin1` FOREIGN KEY (`Admin_idAdmin`) REFERENCES `Admin` (`idAdmin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cuenta_Apartamento1` FOREIGN KEY (`Apartamento_idApartamento`) REFERENCES `Apartamento` (`idApartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cuenta_EstadoPago1` FOREIGN KEY (`EstadoPago_idEstadoPago`) REFERENCES `EstadoPago` (`idEstadoPago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Pagos`
--
ALTER TABLE `Pagos`
  ADD CONSTRAINT `fk_Pagos_Cuenta1` FOREIGN KEY (`Cuenta_idCuenta`) REFERENCES `Cuenta` (`idCuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
