CREATE TABLE `feeds` (
  `id` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `LastUpdate` int(11) NOT NULL UNIQUE KEY,
  `HitCount` int(11) UNSIGNED NOT NULL,
  `LastTag` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE(NOW())), 1008, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 1 day)), 1001, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 2 day)), 1001, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 3 day)), 1001, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 4 day)), 1001, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 5 day)), 1001, 'str 24 chars incl tail 0');
INSERT INTO `feeds` (`id`, `LastUpdate`, `HitCount`, `LastTag`) VALUES (NULL, UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()), INTERVAL 6 day)), 1001, 'str 24 chars incl tail 0');