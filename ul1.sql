--
-- Tabeli struktuur tabelile `languages`
--

CREATE TABLE `languages` (
  `id` int(21) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `languages`
--

INSERT INTO `languages` (`id`, `title`) VALUES
(1, 'Eesti'),
(2, 'Русский'),
(3, 'English');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `workers`
--

CREATE TABLE `workers` (
  `id` int(21) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Nimi',
  `birth_date` date NOT NULL COMMENT 'Sünniaeg',
  `identity_number` varchar(255) NOT NULL COMMENT 'Isikukood',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - Active, 0 - Deactive',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(21) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(21) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `workers_multilingual_data`
--

CREATE TABLE `workers_multilingual_data` (
  `id` int(21) NOT NULL,
  `worker_id` int(21) NOT NULL,
  `language_id` int(21) NOT NULL,
  `introduction` text,
  `experience` text,
  `education` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksid tabelile `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksid tabelile `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identity_number` (`identity_number`),
  ADD KEY `name` (`name`),
  ADD KEY `birth_date` (`birth_date`);

--
-- Indeksid tabelile `workers_multilingual_data`
--
ALTER TABLE `workers_multilingual_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT tabelile `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT tabelile `workers_multilingual_data`
--
ALTER TABLE `workers_multilingual_data`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT;