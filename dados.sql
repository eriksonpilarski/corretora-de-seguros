CREATE TABLE IF NOT EXISTS `propostas_` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proposta` int(11) DEFAULT NULL,
  `segurado` varchar(200) DEFAULT NULL,
  `vig_inicio` date NOT NULL,
  `vig_termino` date DEFAULT NULL,
  `detalhes` varchar(255) NOT NULL,
  `cia` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `apolice` varchar(50) DEFAULT NULL,
  `prem_liq` float DEFAULT NULL,
  `comissao` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO propostas_ (SELECT id, proposta, segurado, renovacao, vencimento, detalhes, cia, tipo, apolice, prem_liq, comissao, status FROM propostas )
