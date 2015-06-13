-- MySQL Script generated by MySQL Workbench
-- 06/13/15 09:41:29
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Assistido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Assistido` (
  `id` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  `nacionalidade` VARCHAR(45) NULL,
  `estadoCivil` VARCHAR(45) NULL,
  `profissao` VARCHAR(45) NULL,
  `identidade` VARCHAR(45) NULL,
  `cpf` VARCHAR(45) NULL,
  `dataNascimento` VARCHAR(45) NULL,
  `nomePai` VARCHAR(45) NULL,
  `nomeMae` VARCHAR(45) NULL,
  `endereco` VARCHAR(45) NULL,
  `rendimentoPessoal` DOUBLE NULL,
  `rendimentoFamiliar` DOUBLE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`AreaAtendimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`AreaAtendimento` (
  `id` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Causa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Causa` (
  `id` INT NOT NULL,
  `relato` VARCHAR(200) NULL,
  `prazoDecadencial` VARCHAR(45) NULL,
  `prazoDrescricional` VARCHAR(45) NULL,
  `dataAtendimento` DATETIME NULL,
  `tipoAcao` VARCHAR(45) NULL,
  `idAreaAtendimento` INT NULL,
  `idAssistido` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_causa_area_atendimento_idx` (`idAreaAtendimento` ASC),
  INDEX `fk_assistido_causa_idx` (`idAssistido` ASC),
  CONSTRAINT `fk_causa_area_atendimento`
    FOREIGN KEY (`idAreaAtendimento`)
    REFERENCES `mydb`.`AreaAtendimento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_assistido_causa`
    FOREIGN KEY (`idAssistido`)
    REFERENCES `mydb`.`Assistido` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ParteContraria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`ParteContraria` (
  `id` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  `enderecoResidencial` VARCHAR(45) NULL,
  `enderecoComercial` VARCHAR(45) NULL,
  `telefone` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `idCausa` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_causa_parte_contraria_idx` (`idCausa` ASC),
  CONSTRAINT `fk_causa_parte_contraria`
    FOREIGN KEY (`idCausa`)
    REFERENCES `mydb`.`Causa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Testemunha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Testemunha` (
  `id` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  `endereco` VARCHAR(45) NULL,
  `telefone` VARCHAR(45) NULL,
  `idCausa` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_causa_testemunha_idx` (`idCausa` ASC),
  CONSTRAINT `fk_causa_testemunha`
    FOREIGN KEY (`idCausa`)
    REFERENCES `mydb`.`Causa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Andamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Andamento` (
  `id` INT NOT NULL,
  `descricao` VARCHAR(45) NULL,
  `localAudiencia` VARCHAR(45) NULL,
  `dataHora` DATETIME NULL,
  `idCausa` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_causa_andamento_idx` (`idCausa` ASC),
  CONSTRAINT `fk_causa_andamento`
    FOREIGN KEY (`idCausa`)
    REFERENCES `mydb`.`Causa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
