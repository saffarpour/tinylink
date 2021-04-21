# tinylink
Small open-source, single-page application (SPA) responsive short link creator written in PHP.

## Introduction 

The Short Link Creator is capable to create short link with one click, it generate a unique Id or customized id (vanity id) link in to the database. User interface checks the long URL and the short URL to be valid before let you to proceed and create a short link. 

## Description 

Application creates short links (like bit.ly or cutt.ly). 

* Shortened link identifiers are unique strings of 5-9 alphanumeric characters
* Code is in MVC design patterns
* Uses REST API
* User can enter vanity URLs
* Users can see number of users redirected by specific URL
* Both long and short URL should be validated before letting user to create a link
* Generates QR codes
* Links are stored in a database

## Usage

- Main page (/) – contains a form where long URLs can be input and submitted. 
Example: 
> localhost/  or localhost/tinylink/

- Form redirects to the "Result" on success.

- Short link info page (/view/abcd123) – shows information about the shortened URL. Example: 
> localhost/view/dduck  or localhost/tinylink/view/dduck

- Redirect link (/abcd123) – looks up the full URL and redirects to it. Example:
> localhost/dduck  or localhost/tinylink/dduck


## DB schema

### Database Name

> tinylink
 
### Table Name
 
> short_links

This simple application has just one table named: short_links
 <p>
 <p align="left">
  <img src="https://user-images.githubusercontent.com/61523990/115618554-dc659f00-a2c0-11eb-87ff-7294cf244b5d.png"/>
</p>

#### SQl source code to create database:

```html
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `tinylink`
USE `tinylink`;

-- Table structure for table `short_links`
CREATE TABLE `short_links` (
  `id` bigint(20) NOT NULL COMMENT 'primary key',
  `original_url` varchar(512) NOT NULL COMMENT 'Original URL ',
  `tiny_link` varchar(10) NOT NULL COMMENT 'Tiny link, both vanity and system generated',
  `hit_counter` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Hit Counter',
  `creation_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Time of creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Created by Reza';

-- Data for table `short_links`
INSERT INTO `short_links` (`id`, `original_url`, `tiny_link`, `hit_counter`, `creation_date`) 
VALUES
(1, 'https://duckduckgo.com', 'dduck', 9, '2021-04-16 10:10:10'),
(2, 'https://stackoverflow.com', 'stack', 15, '2021-04-16 20:20:20');

-- Indexes for table `short_links`
ALTER TABLE `short_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_tiny_link` (`tiny_link`),
  ADD UNIQUE KEY `IDX_original_url` (`id`);

-- AUTO_INCREMENT for table `short_links`
ALTER TABLE `short_links`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=3;
COMMIT;

```

## Install

### Database
 Run the SQL to createdatabase schema
 
### Source code
 1. Copy source code to the desired place.
 2. Enter your database informaton (user name, password, ...) to the file
DatabaseConnector.php
3. change last line of .htaccess file

#### If installing in a subdir 
>RewriteRule . /[your subdir name]/index.php/ [L]
#### If installing in server root 
>RewriteRule . /index.php/ [L]

4. Enter subdir name to the file Config.php
> const SUB_DIR = "[your subdir name]"; //for installing in root do not enter any.

## Live

you can see a live version of website in
 http://tinylink.c1.biz
