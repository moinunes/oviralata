<?php




************************ cadastro de tipos de serviço


https://meuguiapet.com



div onclick="mostrar_detalhes('<?=$anuncio->id_anuncio?>')">

ubuntu sem senha

1 - criar tbanuncio->destaque
        e exibir em mostrar detakhes

2 - criar banner para desaparecido







https://developers.facebook.com/tools/debug/sharing/?q=www.oviralata.com.br



DROP TABLE IF EXISTS `tbtipo_servico`;
CREATE TABLE `tbtipo_servico` (
  `id_tipo_servico` int(11) NOT NULL AUTO_INCREMENT,
  `tiposervico` varchar(60) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  KEY `id_servico` (`id_tipo_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbtipo_servico` ( `tiposervico`, `ordem`) VALUES
( 'Adestramento',   1),
( 'Arte - Foto', 2),
( 'Banho e Tosa',   3),
( 'Beleza, Estética, Higiene',  4),
( 'Blog, site, portal Pet',  5),
( 'Day Care - Hotel, Creche',   6),
( 'Dog walker - Pet Sitter, passeador - cuidador',   7),
( 'Festas Pet',  8),
( 'Moda Pet', 9),
( 'ONGs Pet', 10),
( 'Pet Shop', 11),
( 'Produtos Pet',   12),
( 'Rações, Alimentos', 13),
( 'Saúde Pet',   14),
( 'Taxi Pet', 15),
( 'Outros.',   16),

-- 2019-10-30 12:16:56
