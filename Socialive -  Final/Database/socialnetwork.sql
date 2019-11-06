-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2017 at 09:48 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `socialnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(9, 'Welcome...', 'admin_admin', 'rock_ven', '2017-12-06 14:51:50', 'no', 20),
(10, 'How''s You Doing?\r\n', 'admin_admin', 'rock_ven', '2017-12-06 14:54:02', 'no', 20),
(11, 'Yeah...Doing Same..', 'jack_shah_1_2', 'admin_admin', '2017-12-06 14:54:39', 'no', 10),
(12, '', 'admin_admin', 'rock_ven', '2017-12-07 00:52:24', 'no', 20);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_to`, `user_from`) VALUES
(1, 'admin_admin_1', 'admin_admin');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(12, 'admin_admin', 20),
(13, 'rock_ven', 20),
(14, 'rock_ven', 16),
(15, 'admin_admin', 16),
(16, 'admin_admin', 19),
(17, 'rock_ven', 32),
(18, 'rock_ven', 17),
(19, 'rock_ven', 14);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'jack_shah', 'admin_admin', 'Hi Jack..This is Admin.', '2017-12-11 23:12:19', 'yes', 'no', 'no'),
(2, 'jack_shah', 'admin_admin', 'djawndj', '2017-12-11 23:14:02', 'yes', 'no', 'no'),
(3, 'jack_shah', 'admin_admin', 'Who are you?\r\n', '2017-12-11 23:14:09', 'yes', 'no', 'no'),
(4, 'admin_admin', 'jack_shah', 'Hi...Admin', '2017-12-11 23:16:27', 'yes', 'yes', 'no'),
(5, 'admin_admin', 'jack_shah', 'I''m Jack..From London.', '2017-12-11 23:16:44', 'yes', 'yes', 'no'),
(6, 'jack_shah', 'admin_admin', 'Okay...Now I Got It...', '2017-12-12 00:17:06', 'yes', 'no', 'no'),
(7, 'jack_shah', 'admin_admin', 'It''s Good to See You Around Here...\r\n', '2017-12-12 00:17:15', 'yes', 'no', 'no'),
(8, 'jack_shah', 'admin_admin', 'I Hope You''re Enjoying This Website.', '2017-12-12 00:17:26', 'yes', 'no', 'no'),
(9, 'admin_admin', 'jack_shah', 'Yes...I''m Really Enjoying This Website...', '2017-12-12 00:18:25', 'yes', 'yes', 'no'),
(10, 'admin_admin', 'jack_shah', 'You Created It Very Well.', '2017-12-12 00:18:37', 'yes', 'yes', 'no'),
(11, 'admin_admin', 'jack_shah', 'How Much Did It Take To Create This Whole Project?', '2017-12-12 00:18:57', 'yes', 'yes', 'no'),
(12, 'jack_shah', 'admin_admin', 'Well It Takes a Lot of Time...And Still It''s Not Complete..I''m Still Working on it...', '2017-12-12 00:26:12', 'yes', 'no', 'no'),
(13, 'rock_ven', 'admin_admin', 'Hi Bro...Long Time...No See...', '2017-12-12 01:24:06', 'yes', 'yes', 'no'),
(14, 'jack_shah', 'admin_admin', 'What are you working on right now?', '2017-12-12 01:26:37', 'no', 'no', 'no'),
(15, 'rock_ven', 'admin_admin', 'Are You There?', '2017-12-12 23:40:01', 'yes', 'yes', 'no'),
(16, 'rock_ven', 'admin_admin', 'aaaa', '2017-12-12 23:44:45', 'yes', 'yes', 'no'),
(17, 'rock_ven', 'admin_admin', 'bbbb', '2017-12-12 23:48:05', 'yes', 'yes', 'no'),
(18, 'admin_admin', 'iron_man', 'Hello Admin...', '2017-12-13 01:59:57', 'yes', 'yes', 'no'),
(19, 'admin_admin', 'iron_man', 'How Are You?\r\nI Hope Everything is Well...', '2017-12-13 02:00:11', 'yes', 'yes', 'no'),
(20, 'admin_admin', 'mighty_hulk', 'Hello...I''m Hulk.', '2017-12-13 02:06:34', 'yes', 'yes', 'no'),
(21, 'admin_admin', 'admin_admin_1', 'I''m Second Admin...', '2017-12-13 02:08:55', 'yes', 'yes', 'no'),
(24, 'geek_developer', 'admin_admin', 'Hi', '2017-12-13 02:41:30', 'no', 'no', 'no'),
(25, 'admin_admin', 'rock_ven', 'Hi Bro...', '2017-12-13 03:53:36', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, 'rock_ven', 'admin_admin', 'Admin Admin Liked Your Post', 'post.php?id=19', '2017-12-13 14:40:04', 'no', 'yes'),
(2, 'admin_admin', 'rock_ven', 'Rock Ven Posted on Your Profile', 'post.php?id=34', '2017-12-13 14:40:57', 'yes', 'yes'),
(3, 'admin_admin', 'rock_ven', 'Rock Ven Liked Your Post', 'post.php?id=32', '2017-12-13 15:22:47', 'no', 'yes'),
(4, 'admin_admin', 'rock_ven', 'Rock Ven Liked Your Post', 'post.php?id=17', '2017-12-13 15:22:51', 'yes', 'yes'),
(5, 'admin_admin', 'rock_ven', 'Rock Ven Liked Your Post', 'post.php?id=14', '2017-12-13 15:22:55', 'no', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `image` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(1, 'Hi...First Post...', 'admin_admin', 'none', '2017-12-04 15:00:45', 'no', 'no', 0, ''),
(2, 'Second...Second Post...', 'admin_admin', 'none', '2017-12-04 15:02:37', 'no', 'no', 0, ''),
(3, 'Hey...Guys\r\n', 'admin_admin', 'none', '2017-12-04 23:53:20', 'no', 'no', 0, ''),
(4, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:14:54', 'no', 'no', 0, ''),
(5, 'Test Infinite Post...So Post as much as you can...\r\nTest Infinite Post...So Post as much as you can...\r\nTest Infinite Post...So Post as much as you can...\r\n', 'admin_admin', 'none', '2017-12-05 00:15:00', 'no', 'no', 0, ''),
(6, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:05', 'no', 'no', 0, ''),
(7, 'Test Infinite Post...So Post as much as you can...\r\n', 'admin_admin', 'none', '2017-12-05 00:15:09', 'no', 'no', 0, ''),
(8, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:12', 'no', 'no', 0, ''),
(9, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:15', 'no', 'no', 0, ''),
(10, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:17', 'no', 'no', 0, ''),
(11, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:20', 'no', 'no', 0, ''),
(12, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:23', 'no', 'no', 0, ''),
(13, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:25', 'no', 'no', 0, ''),
(14, 'Test Infinite Post...So Post as much as you can...', 'admin_admin', 'none', '2017-12-05 00:15:28', 'no', 'no', 1, ''),
(15, 'awdjiawdjiawdj', 'admin_admin', 'none', '2017-12-05 01:33:07', 'no', 'no', 0, ''),
(16, 'awdjiawdjiawdj', 'admin_admin', 'none', '2017-12-05 01:33:09', 'no', 'no', 2, ''),
(17, 'awdjiawdjiawdj', 'admin_admin', 'none', '2017-12-05 01:33:12', 'no', 'no', 1, ''),
(18, 'adknawkdn', 'admin_admin', 'none', '2017-12-05 11:46:48', 'no', 'yes', 0, ''),
(19, 'One From me Also...\r\n', 'rock_ven', 'none', '2017-12-05 13:19:16', 'no', 'no', 1, ''),
(20, 'Welcome to Socialive\r\n', 'rock_ven', 'none', '2017-12-05 13:19:29', 'no', 'no', 2, ''),
(21, 'Hi\r\n', 'jack_shah', 'none', '2017-12-05 13:20:38', 'no', 'no', 0, ''),
(32, 'adawjdawduh', 'admin_admin', 'rock_ven', '2017-12-09 14:57:55', 'no', 'no', 1, ''),
(33, 'Good Job...You''ve Got Uptill Here...', 'admin_admin', 'none', '2017-12-10 03:28:34', 'no', 'yes', 0, ''),
(34, 'Thanks...You Liked My Posts...', 'rock_ven', 'admin_admin', '2017-12-13 14:40:57', 'no', 'no', 0, ''),
(35, '<br><iframe width=''420'' height=''315'' src=''https://www.youtube.com/embed/0_ANtEhUHWM''></iframe><br>', 'admin_admin', 'none', '2017-12-16 00:45:14', 'no', 'yes', 0, ''),
(36, '<br><iframe width=''420'' height=''315'' src=''https://www.youtube.com/watch?v=HKIIgYFhQlE''></iframe><br>', 'admin_admin', 'none', '2017-12-16 00:55:59', 'no', 'yes', 0, ''),
(37, '<br><iframe width=''420'' height=''315'' src=''https://www.youtube.com/embed/HKIIgYFhQlE''></iframe><br>', 'admin_admin', 'none', '2017-12-16 00:57:22', 'no', 'yes', 0, ''),
(38, '<br><iframe width=''420'' height=''315'' src=''https://www.youtube.com/embed/HKIIgYFhQlE''></iframe><br>', 'admin_admin', 'none', '2017-12-16 00:58:36', 'no', 'yes', 0, ''),
(44, 'Good Night Everyone.', 'admin_admin', 'none', '2017-12-16 02:21:17', 'no', 'yes', 0, ''),
(45, 'Good Night Goku.', 'rock_ven', 'none', '2017-12-16 02:24:13', 'no', 'yes', 0, ''),
(46, 'Where are You on The Steps?', 'admin_admin', 'none', '2017-12-16 03:06:29', 'no', 'no', 0, 'assets/images/posts/5a34405d1475422555260_1791086170919825_3913863383550551677_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE IF NOT EXISTS `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`title`, `hits`) VALUES
('Hello', 2),
('GuysLooking', 2),
('Forward', 2),
('Watch', 2),
('Tomorrows', 2),
('Match', 2),
('Night', 4),
('Goku', 1),
('Steps', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(1, 'Jack', 'Shah', 'jackShah', 'jack@gmail.com', '1234', '2017-12-06', '1', 1, 1, 'no', ''),
(2, 'Jack', 'Shah', 'jack_shah', 'jack1@gmail.com', 'dc647eb65e6711e155375218212b3964', '2017-12-03', 'assets/images/profile_pics/defaults/head_emerald.png', 1, 0, 'no', ','),
(3, 'Jack', 'Shah', 'jack_shah_1', 'Rockben@gmail.com', '2ac9cb7dc02b3c0083eb70898e549b63', '2017-12-03', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ',admin_admin,'),
(4, 'Jack', 'Shah', 'jack_shah_1_2', 'mouse@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-03', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ',admin_admin,rock_ven,'),
(5, 'Rock', 'Ven', 'rock_ven', 'ven@ven.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-03', 'assets/images/profile_pics/defaults/head_deep_blue.png', 4, 3, 'no', ',admin_admin,mighty_hulk,'),
(6, 'Saiyan', 'Goku', 'admin_admin', 'admin@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-03', 'assets/images/profile_pics/admin_adminb476db5b38a8700a912ff93f646ffd49n.jpeg', 43, 5, 'no', ',jack_shah_1_2,rock_ven,jack_shah,iron_man,mighty_hulk,geek_developer,'),
(7, 'Admin2', 'Admin', 'admin_admin_1', 'admin2@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-12', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(8, 'Iron', 'Man', 'iron_man', 'ironman@avengers.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-13', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ',admin_admin,'),
(9, 'Mighty', 'Hulk', 'mighty_hulk', 'hulk@avengers.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-13', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ',admin_admin,rock_ven,'),
(10, 'Geek', 'Developer', 'geek_developer', 'developer@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2017-12-13', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ',admin_admin,');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
