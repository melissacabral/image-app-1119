-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2019 at 07:49 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melissa_image_app_1119`
--
CREATE DATABASE IF NOT EXISTS `melissa_image_app_1119` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `melissa_image_app_1119`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` mediumint(9) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Portraits'),
(2, 'Landscapes'),
(3, 'Black and White'),
(4, 'Pets');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` mediumint(9) NOT NULL,
  `body` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `body`, `date`, `user_id`, `post_id`, `is_approved`) VALUES
(1, 'Hi this is a great post', '2019-11-20 00:00:00', 2, 1, 1),
(2, 'I really like this', '2019-11-25 10:51:21', 1, 1, 1),
(3, 'I don\'t love this', '2019-11-24 00:00:00', 2, 2, 1),
(4, 'this is an approved comment about post 1 by user 2', '2019-11-26 08:01:55', 2, 1, 1),
(5, 'this is not an approved comment and should not be shown to users', '2019-11-26 08:01:55', 1, 1, 0),
(6, 'Great job on this post', '2019-11-26 08:39:18', 2, 1, 1),
(8, 'Happy Monday to you', '2019-12-02 09:53:27', 2, 4, 1),
(18, 'This comment is readable!!!', '2019-12-02 11:34:56', 2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` mediumint(9) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(40) NOT NULL,
  `category_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `date`, `image`, `category_id`, `user_id`, `allow_comments`, `is_published`) VALUES
(1, 'Some example post title', 'this is the body of this post', '2019-11-25 10:48:50', 'https://picsum.photos/id/0/600/600', 3, 2, 0, 1),
(2, 'picture of a guy in a jacket', 'he\'s at the beach or something', '2019-11-25 10:50:36', 'https://picsum.photos/id/1005/600/600', 2, 1, 0, 1),
(3, 'This is a post about a deer', 'It\'s published and written by user number 2. comments are turned off', '2019-11-26 07:59:08', 'https://picsum.photos/id/1003/600/600', 1, 2, 0, 1),
(4, 'Pug in a blanket', 'Comments on, public post by user 1', '2019-11-26 07:59:08', 'https://picsum.photos/id/1025/600/600', 3, 1, 1, 1),
(5, 'This post is not public it should be hidden', 'if you can read this, something aint right', '2019-11-22 00:00:00', 'https://picsum.photos/id/103/600/600', 2, 1, 1, 0),
(6, 'This is a lovely post', 'Published post with comments on', '2019-11-18 00:00:00', 'https://picsum.photos/id/103/600/600', 4, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` mediumint(9) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'happymonday'),
(2, 'love');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `profile_pic` varchar(40) NOT NULL,
  `bio` text NOT NULL,
  `join_date` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `secret_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `join_date`, `is_admin`, `secret_key`) VALUES
(1, 'Melissa', 'mcabral@platt.edu', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', 'randomuser.me/api/portraits/lego/9.jpg', 'I like enchiladas', '2019-11-25 09:55:34', 1, ''),
(2, 'someguy', 'somebody@mail.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', 'randomuser.me/api/portraits/lego/7.jpg', 'I\'m not an admin', '2019-11-25 09:58:41', 0, ''),
(3, 'third user', 'thirdperson@mail.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', 'randomuser.me/api/portraits/lego/3.jpg', 'hi im a lego person', '2019-11-26 11:30:00', 0, ''),
(4, 'fourth person', 'number4@email.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', 'randomuser.me/api/portraits/lego/2.jpg', 'I live in a blue house', '2019-11-26 11:30:37', 0, ''),
(7, 'bananas3', 'me@mail.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', '', '', '2019-12-04 09:59:43', 0, ''),
(8, 'Turtle Person', 'turtle@email.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', '', '', '2019-12-04 10:34:59', 0, ''),
(9, 'sample user', 'bla@mail.com', '4c0f5323855ad8d62e856e8a90cf4005a62c89ad', '', '', '2019-12-04 10:47:20', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
