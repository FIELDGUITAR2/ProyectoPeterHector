SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `Admin` (
  `idAdmin` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Propietario` (
  `idPropietario` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `fechaIngreso` DATE NOT NULL,
  PRIMARY KEY (`idPropietario`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Apartamento` (
  `idApartamento` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `coeficiente` DOUBLE NOT NULL,
  `Propietario_idPropietario` INT NOT NULL,
  PRIMARY KEY (`idApartamento`),
  INDEX `fk_Apartamento_Propietario1_idx` (`Propietario_idPropietario` ASC),
  CONSTRAINT `fk_Apartamento_Propietario1`
    FOREIGN KEY (`Propietario_idPropietario`)
    REFERENCES `Propietario` (`idPropietario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `EstadoPago` (
  `idEstadoPago` INT NOT NULL AUTO_INCREMENT,
  `valor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEstadoPago`)
) ENGINE = InnoDB;

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