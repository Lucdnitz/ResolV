-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 17-Jan-2022 às 16:03
-- Versão do servidor: 5.6.51
-- versão do PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `baseresolv`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alternativa`
--

CREATE TABLE `alternativa` (
  `ID_Alternativa` int(11) NOT NULL,
  `Valor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alternativa`
--

INSERT INTO `alternativa` (`ID_Alternativa`, `Valor`) VALUES
(1, '100'),
(2, '120'),
(3, '50'),
(4, '25'),
(5, '240'),
(6, 'bactérias patogênicas se multiplicam de maneira acelerada.'),
(7, 'antibióticos são utilizados pela população de maneira indiscriminada.'),
(8, 'bactérias possuem plasmídeos que contêm genes relacionados à virulência.'),
(9, 'bactérias podem ser transmitidas para um indivíduo utilizando várias estratégias.'),
(10, 'serviços de saúde precários constituem importantes focos de bactérias patogênicas.'),
(11, 'o existencialismo sartriano.'),
(12, 'o ceticismo iluminista.'),
(13, 'o materialismo histórico.'),
(14, 'a dialética positivista.'),
(15, 'a escolástica medieval.'),
(16, 'O composto I é um alceno.'),
(17, 'O composto I apresenta 2 átomos de carbono secundário.'),
(18, 'O composto II tem maior ponto de ebulição que o composto III.'),
(19, 'O composto III apresenta 12 átomos de hidrogênio.'),
(20, 'O composto IV é um hidrocarboneto.'),
(21, 'os que indicam às normas do uso linguístico correto.'),
(22, 'os autores que descrevem a estrutura da língua.'),
(23, 'os que escrevem livros, ensaios e os publicam em algum suporte.'),
(24, 'os usuários que aproveitam o dom de poder falar, ler ou escrever textos nesta língua.'),
(25, 'são os que defendem a norma padrão aceita pelos usuários mais escolarizados.'),
(26, '6,8 °C.'),
(27, '59,6 °C.'),
(28, '0 °C.'),
(29, '66,8 °C.'),
(30, '19,6 °C.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `ID_Disciplina` int(11) NOT NULL,
  `Nome` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`ID_Disciplina`, `Nome`) VALUES
(1, 'Matemática'),
(2, 'Física'),
(3, 'Português'),
(4, 'Química'),
(5, 'Biologia'),
(6, 'Filosofia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `edita`
--

CREATE TABLE `edita` (
  `fk_Usuario_ID_Usuario` int(11) DEFAULT NULL,
  `fk_Questao_ID_Questao` int(11) DEFAULT NULL,
  `dataEditada` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `possui`
--

CREATE TABLE `possui` (
  `fk_Alternativa_ID_Alternativa` int(11) DEFAULT NULL,
  `fk_Questao_ID_Questao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `possui`
--

INSERT INTO `possui` (`fk_Alternativa_ID_Alternativa`, `fk_Questao_ID_Questao`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 5),
(22, 5),
(23, 5),
(24, 5),
(25, 5),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `questao`
--

CREATE TABLE `questao` (
  `ID_Questao` int(11) NOT NULL,
  `Enunciado` varchar(2000) DEFAULT NULL,
  `Solucao` varchar(2000) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `Aprovada` tinyint(4) DEFAULT NULL,
  `fk_Disciplina_ID_Disciplina` int(11) DEFAULT NULL,
  `fk_Usuario_ID_Usuario` int(11) DEFAULT NULL,
  `dataCriada` date DEFAULT NULL,
  `fk_Alternativa_ID_Alternativa` int(11) DEFAULT NULL,
  `fk_Vestibular_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `questao`
--

INSERT INTO `questao` (`ID_Questao`, `Enunciado`, `Solucao`, `Ano`, `Aprovada`, `fk_Disciplina_ID_Disciplina`, `fk_Usuario_ID_Usuario`, `dataCriada`, `fk_Alternativa_ID_Alternativa`, `fk_Vestibular_ID`) VALUES
(1, 'Duas caixas A e B, contêm exatamente 5 bolas cada uma. Retiram-se duas bolas de cada caixa, aleatoriamente. O número de elementos do espaço amostral relativo a esse experimento é exatamente:', 'O número de formas de escolher as 2 bolas em uma caixa será C 5,2. \n\nComo temos duas caixas, o total de possibilidades de escolha será:\n\nC 5,2 . C 5,2 = 10 . 10 = 100', 1994, 1, 1, NULL, '2021-12-22', 1, 1),
(2, 'Nas últimas décadas vários países, inclusive o Brasil, têm testemunhado uma grande proliferação de bactérias patogênicas, envolvidas em uma variedade de doenças e que apresentam resistência a múltiplos antibióticos. Atualmente têm se destacado as superbactérias que acumularam vários genes determinantes de resistência, a ponto de se tornarem resistentes a praticamente todos os antimicrobianos.', 'A população tem intensificado o uso de antibióticos, por vezes que nem são recomendados, nos últimos anos, e isso tem levado a uma seleção de bactérias mais resistentes conhecidas como superbactérias. Essa resistência ocorre a partir do momento em que o medicamento elimina somente alguns dos organismos infecciosos, enquanto as mais resistentes sobrevivem e transmitem sua capacidade às suas descendências.', 2021, 1, 5, 1, '2022-01-17', 7, 2),
(3, 'Se a tragédia havia absorvido e assimilado todas as formas de arte antecedentes, o mesmo se pode dizer do diálogo platônico. Mistura de todos os estilos e de todas as formas precedentes, o diálogo oscila entre a narrativa, o lirismo e o drama, entre a prosa e a poesia. Platão conseguiu realmente legar à posteridade o modelo de uma obra de arte nova, o do “romance”. Neste gênero literário, a poesia existe gradualmente subordinada à filosofia e durante muitos séculos, mais tarde, a mesma filosofia esteve subordinada à teologia.\r\n(Friedrich Wilhelm Nietzsche. A origem da tragédia, 2004. Adaptado.)\r\n\r\nPode-se exemplificar o argumento sobre a submissão da filosofia à teologia, com', 'Filosofia medieval esteve muito ligada a igreja católica. A igreja católica como um todo teve muita importância na época medieval.', 2018, 1, 6, 1, '2022-01-17', 15, 3),
(4, 'Considere os compostos orgânicos a seguir.\r\n\r\nI. 2-metil-pentano. II. Propano. III. Butano. IV. Cloroetano.\r\n\r\nSobre esses compostos, assinale a alternativa correta.', 'A alternativa B é a única correta', 2015, 1, 4, 1, '2022-01-17', 17, 4),
(5, 'Millôr, exercitando sua competência de linguista por intuição, escreveu a declaração abaixo:\r\n \r\n&#34;Nenhuma língua morreu por falta de gramáticos: algumas estagnaram por ausência de escritores. Nenhuma sobreviveu sem povo.”\r\n \r\nPor essa declaração, fica obviamente declarado que, na constituição e na manutenção de uma língua, o essencial são:', 'A palavra &#34;dom&#34; está no sentido de &#34;aptidão&#34; ou &#34;domínio&#34;, então nesse caso seria que pessoas nas quais tenham a aptidão de utilizar a língua, passam a língua adiante e dessa ela não morrerá.', 2021, 1, 3, 1, '2022-01-17', 24, 5),
(6, 'Uma escala termométrica R foi criada para uso em laboratório. Nela, o valor de 0 °R equivale à temperatura de –20 °C e o valor de 100 °R equivale à temperatura de 40 °C.\r\nNessa escala, a temperatura de 66 °R, corresponde à temperatura de', 'R / 100 = (C + 20) / 60 => R = 66 => C = 19,6 ', 2018, 1, 2, 1, '2022-01-17', 30, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `realiza`
--

CREATE TABLE `realiza` (
  `fk_Usuario_ID_Usuario` int(11) DEFAULT NULL,
  `fk_Questao_ID_Questao` int(11) DEFAULT NULL,
  `Acertou` tinyint(4) DEFAULT NULL,
  `dataRealizada` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `Nome` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Apelido` varchar(45) DEFAULT NULL,
  `Senha` varchar(256) DEFAULT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`Nome`, `Email`, `Apelido`, `Senha`, `ID_Usuario`) VALUES
('Admin', 'admin@resolv.com', 'ADMIN1', '$2y$10$3Xe.5nmqajyCFW.J7U7HWeF5H12GRvxWFfRYl3wkRqMJB9pRzyYyy', 1),
('Admin', 'admin2@resolv.com', 'ADMIN2', '$2y$10$lv5XdHXCBQUQTOyxwPdC/urwYE9QNYOPgtg1CuLk9Ol2j77u2EIl6', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vestibular`
--

CREATE TABLE `vestibular` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vestibular`
--

INSERT INTO `vestibular` (`ID`, `Nome`) VALUES
(1, 'AFA'),
(2, 'ENEM'),
(3, 'VUNESP'),
(4, 'UNICENTRO'),
(5, 'CESMAC');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alternativa`
--
ALTER TABLE `alternativa`
  ADD PRIMARY KEY (`ID_Alternativa`);

--
-- Índices para tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`ID_Disciplina`);

--
-- Índices para tabela `edita`
--
ALTER TABLE `edita`
  ADD KEY `FK_Edita_1` (`fk_Usuario_ID_Usuario`),
  ADD KEY `FK_Edita_2` (`fk_Questao_ID_Questao`);

--
-- Índices para tabela `possui`
--
ALTER TABLE `possui`
  ADD KEY `FK_Possui_1` (`fk_Alternativa_ID_Alternativa`),
  ADD KEY `FK_Possui_2` (`fk_Questao_ID_Questao`);

--
-- Índices para tabela `questao`
--
ALTER TABLE `questao`
  ADD PRIMARY KEY (`ID_Questao`),
  ADD KEY `FK_Questao_2` (`fk_Disciplina_ID_Disciplina`),
  ADD KEY `FK_Questao_3` (`fk_Usuario_ID_Usuario`),
  ADD KEY `FK_Questao_4` (`fk_Alternativa_ID_Alternativa`),
  ADD KEY `FK_Questao_5` (`fk_Vestibular_ID`);

--
-- Índices para tabela `realiza`
--
ALTER TABLE `realiza`
  ADD KEY `FK_Realiza_1` (`fk_Usuario_ID_Usuario`),
  ADD KEY `FK_Realiza_2` (`fk_Questao_ID_Questao`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Índices para tabela `vestibular`
--
ALTER TABLE `vestibular`
  ADD PRIMARY KEY (`ID`);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `edita`
--
ALTER TABLE `edita`
  ADD CONSTRAINT `FK_Edita_1` FOREIGN KEY (`fk_Usuario_ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_Edita_2` FOREIGN KEY (`fk_Questao_ID_Questao`) REFERENCES `questao` (`ID_Questao`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `possui`
--
ALTER TABLE `possui`
  ADD CONSTRAINT `FK_Possui_1` FOREIGN KEY (`fk_Alternativa_ID_Alternativa`) REFERENCES `alternativa` (`ID_Alternativa`),
  ADD CONSTRAINT `FK_Possui_2` FOREIGN KEY (`fk_Questao_ID_Questao`) REFERENCES `questao` (`ID_Questao`);

--
-- Limitadores para a tabela `questao`
--
ALTER TABLE `questao`
  ADD CONSTRAINT `FK_Questao_2` FOREIGN KEY (`fk_Disciplina_ID_Disciplina`) REFERENCES `disciplina` (`ID_Disciplina`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Questao_3` FOREIGN KEY (`fk_Usuario_ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_Questao_4` FOREIGN KEY (`fk_Alternativa_ID_Alternativa`) REFERENCES `alternativa` (`ID_Alternativa`),
  ADD CONSTRAINT `FK_Questao_5` FOREIGN KEY (`fk_Vestibular_ID`) REFERENCES `vestibular` (`ID`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `FK_Realiza_1` FOREIGN KEY (`fk_Usuario_ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `FK_Realiza_2` FOREIGN KEY (`fk_Questao_ID_Questao`) REFERENCES `questao` (`ID_Questao`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
