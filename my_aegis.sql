-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Nov 24, 2016 alle 11:22
-- Versione del server: 10.1.16-MariaDB
-- Versione PHP: 5.6.24

create database 'my_aegis`;
USE 'my_aegis`
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_aegis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appezzamento`
--

CREATE TABLE `appezzamento` (
  `idappezzamento` int(3) NOT NULL,
  `iduliveto` int(3) NOT NULL,
  `note` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `componente`
--

CREATE TABLE `componente` (
  `idcomponente` int(3) NOT NULL,
  `descrizione` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `nodo`
--

CREATE TABLE `nodo` (
  `idnodo` int(3) NOT NULL,
  `stato` int(1) NOT NULL,
  `indice-posizione` varchar(1) COLLATE utf8_bin NOT NULL,
  `gprs` tinyint(1) NOT NULL,
  `idappezzamento` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `possesso`
--

CREATE TABLE `possesso` (
  `idpossesso` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL,
  `idcomponente` int(3) NOT NULL,
  `stato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `temperatura`
--

CREATE TABLE `temperatura` (
  `idtemperatura` int(3) NOT NULL,
  `data` int(11) NOT NULL,
  `temperatura` int(11) NOT NULL,
  `idnodo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `trappola`
--

CREATE TABLE `trappola` (
  `idtrappola` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL,
  `conta` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `uliveto`
--

CREATE TABLE `uliveto` (
  `iduliveto` int(3) NOT NULL,
  `descrizione` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `umidita`
--

CREATE TABLE `umidita` (
  `idumidita` int(3) NOT NULL,
  `data` datetime NOT NULL,
  `umidita` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idutente` int(3) NOT NULL,
  `nome` varchar(30) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(30) COLLATE utf8_bin NOT NULL,
  `ruolo` varchar(30) COLLATE utf8_bin NOT NULL,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `password` varchar(25) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appezzamento`
--
ALTER TABLE `appezzamento`
  ADD PRIMARY KEY (`idappezzamento`),
  ADD KEY `iduliveto` (`iduliveto`);

--
-- Indici per le tabelle `componente`
--
ALTER TABLE `componente`
  ADD PRIMARY KEY (`idcomponente`);

--
-- Indici per le tabelle `nodo`
--
ALTER TABLE `nodo`
  ADD PRIMARY KEY (`idnodo`),
  ADD KEY `idappezzamento` (`idappezzamento`);

--
-- Indici per le tabelle `possesso`
--
ALTER TABLE `possesso`
  ADD PRIMARY KEY (`idpossesso`),
  ADD KEY `idnodo` (`idnodo`),
  ADD KEY `idcomponente` (`idcomponente`);

--
-- Indici per le tabelle `temperatura`
--
ALTER TABLE `temperatura`
  ADD PRIMARY KEY (`idtemperatura`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `trappola`
--
ALTER TABLE `trappola`
  ADD PRIMARY KEY (`idtrappola`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `uliveto`
--
ALTER TABLE `uliveto`
  ADD PRIMARY KEY (`iduliveto`);

--
-- Indici per le tabelle `umidita`
--
ALTER TABLE `umidita`
  ADD PRIMARY KEY (`idumidita`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idutente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appezzamento`
--
ALTER TABLE `appezzamento`
  MODIFY `idappezzamento` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `componente`
--
ALTER TABLE `componente`
  MODIFY `idcomponente` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `nodo`
--
ALTER TABLE `nodo`
  MODIFY `idnodo` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `possesso`
--
ALTER TABLE `possesso`
  MODIFY `idpossesso` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `temperatura`
--
ALTER TABLE `temperatura`
  MODIFY `idtemperatura` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `trappola`
--
ALTER TABLE `trappola`
  MODIFY `idtrappola` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `uliveto`
--
ALTER TABLE `uliveto`
  MODIFY `iduliveto` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `umidita`
--
ALTER TABLE `umidita`
  MODIFY `idumidita` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idutente` int(3) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appezzamento`
--
ALTER TABLE `appezzamento`
  ADD CONSTRAINT `esistenza_uliveto` FOREIGN KEY (`iduliveto`) REFERENCES `uliveto` (`iduliveto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nodo`
--
ALTER TABLE `nodo`
  ADD CONSTRAINT `esistenza_appezzamento` FOREIGN KEY (`idappezzamento`) REFERENCES `appezzamento` (`idappezzamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `temperatura`
--
ALTER TABLE `temperatura`
  ADD CONSTRAINT `esistenza_nodo_temperatura` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `trappola`
--
ALTER TABLE `trappola`
  ADD CONSTRAINT `esistenza_nodo_trappola` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `umidita`
--
ALTER TABLE `umidita`
  ADD CONSTRAINT `esistenza_nodo_umidita` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
