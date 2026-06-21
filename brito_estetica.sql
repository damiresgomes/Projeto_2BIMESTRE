-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2026 às 03:26
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `brito_estetica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id_agendamento` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `placa_veiculo` varchar(10) DEFAULT NULL,
  `modelo_veiculo` varchar(50) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento_servico`
--

CREATE TABLE `agendamento_servico` (
  `id_agendamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `telefone`) VALUES


-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `nome_servico` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `tipo_servico` enum('principal','extra') NOT NULL DEFAULT 'principal',
  `duracao` int(11) DEFAULT NULL,
  `duracao_horas` decimal(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `nome_servico`, `descricao`, `preco`, `tipo_servico`, `duracao`, `duracao_horas`) VALUES
(1, 'Lavagem Detalhada', 'Uma limpeza externa completa com secagem manual, vidros limpos e acabamento nos pneus. Ideal para\r\n                    quem usa o carro diariamente e quer manter a aparência sempre impecável sem gastar muito tempo.', 150.00, 'principal', 0, 3.00),
(2, 'Higienização Interna Completa', 'Serviço premium que cuida do interior do veículo: aspiração profunda, limpeza de painel, portas e vidros, além de aromatização. Indicado para quem deseja eliminar poeira, ácaros e odores, deixando o carro com aspecto de novo.', 1200.00, 'principal', 0, 7.00),
(3, 'Restauração de Faróis', 'Recupera a transparência dos faróis, removendo opacidade e pequenos riscos. Inclui polimento, aplicação de cera e proteção UV. Melhora a estética e aumenta a segurança à noite.', 250.00, 'principal', 0, 3.00),
(4, 'Polimento Comercial', 'Corrige arranhões leves e devolve brilho à pintura. A cristalização protege contra desgaste e o tratamento UV prolonga a vida da pintura. É uma opção intermediária para quem quer renovar o visual sem investir em polimento técnico.', 700.00, 'principal', 0, 6.00),
(5, 'Limpeza de Motor', 'Limpeza cuidadosa do compartimento do motor, removendo sujeira e oleosidade sem danificar componentes elétricos. Inclui proteção UV e cristalização da pintura. Além da estética, ajuda na manutenção preventiva.', 400.00, 'principal', 0, 4.00),
(6, 'Polimento Técnico + Vitrificação', 'Processo avançado que corrige microarranhões e imperfeições da pintura. Finalizado com vitrificação cerâmica, que cria uma camada protetora contra sol, chuva e sujeira. É o serviço mais indicado para carros novos ou de luxo.', 2500.00, 'principal', 0, 11.00),
(7, 'Vitrificação de Plástico', 'Tratamento que protege plásticos internos e externos contra ressecamento e desbotamento. Mantém a textura original e dá aspecto renovado às peças.', 700.00, 'principal', 0, 3.50),
(8, 'Limpeza de Chassi', 'Limpeza profunda da parte inferior do veículo, removendo barro, óleo e resíduos. Inclui proteção anticorrosiva, essencial para quem roda em estradas de terra ou regiões úmidas.', 500.00, 'principal', 0, 4.00),
(9, 'Higienização dos Bancos', 'Limpeza completa dos bancos em tecido ou couro, removendo manchas e odores. No couro, inclui hidratação para evitar rachaduras. Garante conforto e preserva o valor do veículo.', 800.00, 'principal', 0, 6.00),
(10, 'Polimento Técnico', 'Polimento detalhado para correção de riscos leves.', 200.00, 'extra', 0, 5.00),
(11, 'Hidratação de Couro', 'Tratamento para manter o couro macio e protegido.', 200.00, 'extra', 0, 2.00),
(12, 'Cristalização de Vidros', 'Aplicação de produto repelente de água nos vidros.', 200.00, 'extra', 0, 2.00),
(13, 'Limpeza do Motor (extra)', 'Serviço adicional de higienização do motor.', 400.00, 'extra', 0, 2.00),
(14, 'Cera Líquida', 'Aplicação rápida de cera para proteção e brilho da pintura.', 80.00, 'extra', 0, 1.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD PRIMARY KEY (`id_agendamento`,`id_servico`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Restrições para tabelas `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD CONSTRAINT `agendamento_servico_ibfk_1` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamentos` (`id_agendamento`),
  ADD CONSTRAINT `agendamento_servico_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
