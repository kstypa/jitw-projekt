-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 17 Gru 2017, 21:27
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `testlog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `game_id`, `user_id`, `timestamp`, `text`) VALUES
(1, 1, 5, '2017-11-24 04:04:51', 'Super gra!'),
(2, 1, 3, '2017-11-24 03:44:27', 'Dobra zabawa blin'),
(3, 1, 4, '2017-11-24 03:44:45', 'Rush B!'),
(4, 4, 6, '2017-11-24 04:08:25', 'Yeah!'),
(5, 1, 3, '2017-12-05 11:54:45', 'add comment test'),
(6, 1, 3, '2017-12-15 10:59:22', 'dodajemy komentarz xd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `play_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `games`
--

INSERT INTO `games` (`id`, `name`, `play_count`) VALUES
(1, 'Snake', 0),
(2, 'Wisielec', 0),
(3, 'Space Invaders', 0),
(4, 'Arkanoid', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `ratings`
--

INSERT INTO `ratings` (`id`, `game_id`, `user_id`, `rating`) VALUES
(1, 1, 3, 5),
(2, 1, 4, 5),
(3, 1, 5, 4),
(4, 2, 5, 3),
(5, 2, 4, 4),
(6, 3, 7, 5),
(7, 1, 7, 3),
(8, 3, 3, 2),
(9, 4, 6, 5),
(10, 4, 2, 4),
(11, 1, 6, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `scores`
--

INSERT INTO `scores` (`id`, `game_id`, `user_id`, `timestamp`, `score`) VALUES
(1, 1, 7, '2017-11-24 03:40:42', 1500),
(2, 1, 5, '2017-11-24 03:40:42', 1200),
(3, 1, 4, '2017-11-24 03:41:12', 1700),
(4, 1, 3, '2017-11-24 03:41:12', 2000),
(5, 4, 6, '2017-11-24 03:41:48', 2200),
(6, 4, 2, '2017-11-24 03:41:48', 1900),
(7, 2, 5, '2017-11-24 03:42:17', 700),
(8, 2, 4, '2017-11-24 03:42:17', 500),
(9, 3, 3, '2017-11-24 03:42:52', 65000),
(10, 3, 7, '2017-11-24 03:42:52', 70000);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `registered` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `group_id`, `registered`, `last_login`, `ip`) VALUES
(1, 'admin', '207023ccb44feb4d7dadca005ce29a64', 'admin@admin.pl', 1, 1357063200, 1357063200, '127.0.0.1'),
(2, 'test', '96e79218965eb72c92a549dd5a330112', 'test@test.tt', 3, 1510880350, 1510880350, '::1'),
(3, 'boris', 'e5ab046d461a87a79075ed82dc521c15', 'slavking@mayonez.com', 0, 1511494308, 1511494308, '::1'),
(4, 'anatoli22', 'e10adc3949ba59abbe56e057f20f883e', 'cousin@mayonez.com', 0, 1511494503, 1511494503, '::1'),
(5, 'yunaffx', '96e79218965eb72c92a549dd5a330112', 'yuna@besaid.net', 0, 1511494581, 1511494581, '::1'),
(6, 'doom_marine', '96e79218965eb72c92a549dd5a330112', 'doomguy@uac.com', 0, 1511494640, 1511494640, '::1'),
(7, 'baja', '96e79218965eb72c92a549dd5a330112', 'maliknindza@krajina.yu', 0, 1511494774, 1511494774, '::1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
