-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbbairro`;
CREATE TABLE `tbbairro` (
  `id_bairro` int(11) NOT NULL AUTO_INCREMENT,
  `nome_bairro` varchar(60) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  PRIMARY KEY (`id_bairro`),
  UNIQUE KEY `id_municipio_nome_bairro` (`id_municipio`,`nome_bairro`),
  CONSTRAINT `tbbairro_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `tbmunicipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbdomicilio`;
CREATE TABLE `tbdomicilio` (
  `id_domicilio` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(40) NOT NULL,
  `id_logradouro` int(11) NOT NULL,
  PRIMARY KEY (`id_domicilio`),
  KEY `id_logradouro` (`id_logradouro`),
  CONSTRAINT `tbdomicilio_ibfk_1` FOREIGN KEY (`id_logradouro`) REFERENCES `tblogradouro` (`id_logradouro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tblogradouro`;
CREATE TABLE `tblogradouro` (
  `id_logradouro` int(11) NOT NULL AUTO_INCREMENT,
  `nome_logradouro` varchar(60) NOT NULL,
  `complemento` varchar(40) NOT NULL,
  `cep` char(8) NOT NULL,
  `local` char(40) NOT NULL,
  `id_bairro` int(11) NOT NULL,
  PRIMARY KEY (`id_logradouro`),
  UNIQUE KEY `cep` (`cep`),
  KEY `id_bairro` (`id_bairro`),
  CONSTRAINT `tblogradouro_ibfk_1` FOREIGN KEY (`id_bairro`) REFERENCES `tbbairro` (`id_bairro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbmunicipio`;
CREATE TABLE `tbmunicipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `nome_municipio` varchar(60) NOT NULL,
  `id_uf` int(11) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `id_uf` (`id_uf`),
  CONSTRAINT `tbmunicipio_ibfk_1` FOREIGN KEY (`id_uf`) REFERENCES `tbuf` (`id_uf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbuf`;
CREATE TABLE `tbuf` (
  `id_uf` int(11) NOT NULL AUTO_INCREMENT,
  `nome_uf` char(2) NOT NULL,
  PRIMARY KEY (`id_uf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-07-07 09:27:11