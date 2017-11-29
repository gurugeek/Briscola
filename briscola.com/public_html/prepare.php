<?php

// Manualno inicijaliziramo bazu ako već nije.
include_once dirname(__FILE__) . '/model/db.class.php';

echo "Class is ok";
$db = DB::getConnection();

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS user (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'nickname varchar(100) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error kod izrade tablice igre: " . $e->getMessage() ); }

echo "Users created.<br />";
//waitList for play
try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS waitList (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'nickname varchar(100) NOT NULL)' //if the first player is first.
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error kod izrade userList: " . $e->getMessage() ); }

echo "waitList created.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS playing (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'player1 varchar(100) NOT NULL,' .
		'player2 varchar(100) NOT NULL,' .
    'shuffeledCards varchar(255) NOT NULL,' .
    'first boolean DEFAULT false)' //if the first player is first.

	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error kod izrade userList: " . $e->getMessage() ); }

echo "Playing created.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS waitAnswer (' .
		'id varchar(100) NOT NULL PRIMARY KEY,' .
		'thrownCard int)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error kod tablice onlines: " . $e->getMessage() ); }

echo "Wait answer created.<br />";
