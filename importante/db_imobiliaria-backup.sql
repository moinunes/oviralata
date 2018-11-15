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


DROP TABLE IF EXISTS `tbimovel`;
CREATE TABLE `tbimovel` (
  `id_imovel` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_imovel` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text,
  `proprietario_nome` varchar(255) DEFAULT NULL,
  `proprietario_dados` text,
  `endereco_imovel` varchar(255) DEFAULT NULL,
  `valor_imovel` double(18,2) DEFAULT NULL,
  `valor_condominio` varchar(20) DEFAULT NULL,
  `valor_iptu` varchar(20) DEFAULT NULL,
  `valor_laudemio` varchar(20) DEFAULT NULL,
  `qtd_quartos` varchar(3) DEFAULT NULL,
  `qtd_banheiro` varchar(3) DEFAULT NULL,
  `qtd_vaga` varchar(3) DEFAULT NULL,
  `qtd_suite` varchar(3) DEFAULT NULL,
  `area_util` varchar(10) DEFAULT NULL,
  `area_total` varchar(10) DEFAULT NULL,
  `idade_imovel` varchar(3) DEFAULT NULL,
  `tem_escritura` varchar(3) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `ativo` char(1) DEFAULT 'N',
  `lavanderia` varchar(1) DEFAULT NULL,
  `salao_festa` char(1) DEFAULT NULL,
  `churrasqueira` char(1) DEFAULT NULL,
  `academia` char(1) DEFAULT NULL,
  `ar_condicionado` char(1) DEFAULT NULL,
  `piscina` char(1) DEFAULT NULL,
  `prox_mercado` char(1) DEFAULT NULL,
  `prox_hospital` char(1) DEFAULT NULL,
  `id_domicilio_imovel` int(11) DEFAULT NULL,
  `id_domicilio_proprietario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_imovel`),
  KEY `id_domicilio_imovel` (`id_domicilio_imovel`),
  KEY `id_domicilio_proprietario` (`id_domicilio_proprietario`),
  KEY `id_tipo_imovel` (`id_tipo_imovel`),
  CONSTRAINT `tbimovel_ibfk_1` FOREIGN KEY (`id_domicilio_imovel`) REFERENCES `tbdomicilio` (`id_domicilio`),
  CONSTRAINT `tbimovel_ibfk_2` FOREIGN KEY (`id_domicilio_proprietario`) REFERENCES `tbdomicilio` (`id_domicilio`),
  CONSTRAINT `tbimovel_ibfk_3` FOREIGN KEY (`id_tipo_imovel`) REFERENCES `tbtipo_imovel` (`id_tipo_imovel`)
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


DROP TABLE IF EXISTS `tbtipo_imovel`;
CREATE TABLE `tbtipo_imovel` (
  `id_tipo_imovel` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_imovel` varchar(60) NOT NULL,
  PRIMARY KEY (`id_tipo_imovel`),
  UNIQUE KEY `tipo_imovel` (`tipo_imovel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tbuf`;
CREATE TABLE `tbuf` (
  `id_uf` int(11) NOT NULL AUTO_INCREMENT,
  `nome_uf` char(2) NOT NULL,
  PRIMARY KEY (`id_uf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-10-17 07:28:59
