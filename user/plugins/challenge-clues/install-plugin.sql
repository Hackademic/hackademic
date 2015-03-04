--
-- Table structure for table `clues`
--

CREATE TABLE IF NOT EXISTS `clues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challenge` int(11) NOT NULL,
  `clue_text` text NOT NULL,
  `penalty` int(11) DEFAULT '0',
  `enabled` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  FOREIGN KEY(`challenge`) REFERENCES challenges(`id`)
);

--
-- Dumping data for table `clues`
--

INSERT INTO `clues`(`id`, `challenge`, `clue_text`, `penalty`, `enabled`) VALUES
(1, 1, 'The admin is also the developer and he kept a reminder somewhere.', 1, 1),
(2, 1, 'Look for invisible things.', 2, 1),
(3, 2, 'You should use the developer console of your browser.', 1, 1),
(4, 3, 'Try XSS attacks.', 1, 1),
(5, 4, 'There is a protection to prevent the use of quotes.', 1, 1),
(6, 4, 'See character encoding in JavaScript.', 2, 1),
(7, 5, 'The browser is sending a value than all servers can use to identify it.', 1, 1),
(8, 5, 'Look at the user-agent.', 2, 1),
(9, 6, 'Debugging might help.', 1, 1),
(10, 6, 'It\'s URL encoded', 2, 1),
(11, 7, 'Look at the cookies.', 1, 1),
(12, 8, 'Try to list the files on the server.', 1, 1),
(13, 9, 'Try the user-agent header.', 1, 1),
(14, 9, 'Try to inject PHP code.', 2, 1),
(15, 10, 'Look for hidden things.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_clues`
--

CREATE TABLE IF NOT EXISTS `user_clues` (
  `user` int(11) NOT NULL,
  `clue` int(11) NOT NULL,
  PRIMARY KEY (`user`, `clue`),
  FOREIGN KEY(`user`) REFERENCES users(`id`),
  FOREIGN KEY(`clue`) REFERENCES clues(`id`)
);
