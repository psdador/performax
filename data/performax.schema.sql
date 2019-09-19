DROP TABLE IF EXISTS `performax`.`users`;
CREATE TABLE `performax`.`users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT NOW(),
  `position` VARCHAR(100),
  `id_number` VARCHAR(150) DEFAULT '00000',
  `birthday` DATE,
  `contact` VARCHAR(50),
  `locked` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);

