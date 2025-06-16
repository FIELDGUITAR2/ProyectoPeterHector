-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2025 at 01:20 AM
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
-- Database: `Conjunto2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Apartamento`
--

CREATE TABLE `Apartamento` (
  `ID_Propietario` int(11) NOT NULL,
  `Numero_Apartamento` int(11) NOT NULL,
  `Bloque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cuenta`
--

CREATE TABLE `Cuenta` (
  `ID_Cuenta` int(11) NOT NULL,
  `Numero_Apartamento` int(11) NOT NULL,
  `Bloque` int(11) NOT NULL,
  `MesesPagados` int(11) NOT NULL,
  `MontoMensual` double NOT NULL,
  `MesesTotales` int(11) NOT NULL,
  `Saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Estado`
--

CREATE TABLE `Estado` (
  `ID_Estado` int(11) NOT NULL,
  `Nombre_Estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Paga`
--

CREATE TABLE `Paga` (
  `ID_Pago` int(11) NOT NULL,
  `ID_Estado` int(11) NOT NULL,
  `ID_Cuenta` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Tot_Pagar` double NOT NULL,
  `Monto_Recibido` double NOT NULL,
  `Saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Persona`
--

CREATE TABLE `Persona` (
  `ID_Persona` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(100) NOT NULL,
  `Contrasenia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Rol`
--

CREATE TABLE `Rol` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Rol_Persona`
--

CREATE TABLE `Rol_Persona` (
  `ID_Persona` int(11) NOT NULL,
  `ID_Rol` int(11) NOT NULL,
  `ID_Cuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Apartamento`
--
ALTER TABLE `Apartamento`
  ADD PRIMARY KEY (`Numero_Apartamento`,`Bloque`),
  ADD KEY `ID_Propietario` (`ID_Propietario`);

--
-- Indexes for table `Cuenta`
--
ALTER TABLE `Cuenta`
  ADD PRIMARY KEY (`ID_Cuenta`),
  ADD KEY `Numero_Apartamento` (`Numero_Apartamento`,`Bloque`);

--
-- Indexes for table `Estado`
--
ALTER TABLE `Estado`
  ADD PRIMARY KEY (`ID_Estado`);

--
-- Indexes for table `Paga`
--
ALTER TABLE `Paga`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `ID_Estado` (`ID_Estado`),
  ADD KEY `ID_Cuenta` (`ID_Cuenta`);

--
-- Indexes for table `Persona`
--
ALTER TABLE `Persona`
  ADD PRIMARY KEY (`ID_Persona`);

--
-- Indexes for table `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`ID_Rol`);

--
-- Indexes for table `Rol_Persona`
--
ALTER TABLE `Rol_Persona`
  ADD KEY `ID_Rol` (`ID_Rol`),
  ADD KEY `ID_Persona` (`ID_Persona`),
  ADD KEY `ID_Cuenta` (`ID_Cuenta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cuenta`
--
ALTER TABLE `Cuenta`
  MODIFY `ID_Cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Estado`
--
ALTER TABLE `Estado`
  MODIFY `ID_Estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Paga`
--
ALTER TABLE `Paga`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Rol`
--
ALTER TABLE `Rol`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Apartamento`
--
ALTER TABLE `Apartamento`
  ADD CONSTRAINT `Apartamento_ibfk_1` FOREIGN KEY (`ID_Propietario`) REFERENCES `Persona` (`ID_Persona`);

--
-- Constraints for table `Cuenta`
--
ALTER TABLE `Cuenta`
  ADD CONSTRAINT `Cuenta_ibfk_1` FOREIGN KEY (`Numero_Apartamento`,`Bloque`) REFERENCES `Apartamento` (`Numero_Apartamento`, `Bloque`);

--
-- Constraints for table `Paga`
--
ALTER TABLE `Paga`
  ADD CONSTRAINT `Paga_ibfk_1` FOREIGN KEY (`ID_Estado`) REFERENCES `Estado` (`ID_Estado`),
  ADD CONSTRAINT `Paga_ibfk_2` FOREIGN KEY (`ID_Cuenta`) REFERENCES `Cuenta` (`ID_Cuenta`);

--
-- Constraints for table `Rol_Persona`
--
ALTER TABLE `Rol_Persona`
  ADD CONSTRAINT `Rol_Persona_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `Rol` (`ID_Rol`),
  ADD CONSTRAINT `Rol_Persona_ibfk_2` FOREIGN KEY (`ID_Persona`) REFERENCES `Persona` (`ID_Persona`),
  ADD CONSTRAINT `Rol_Persona_ibfk_3` FOREIGN KEY (`ID_Cuenta`) REFERENCES `Cuenta` (`ID_Cuenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
