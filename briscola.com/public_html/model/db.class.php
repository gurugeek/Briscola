<?php

// The file should be renamed in db.class.php
/**
* The vase to the database.
* Includes ststičku variable $ db that represents the connection to the base. If it has not yet been established, its value is
* {@ Code null}. Connecting to a occurs only in case when the $ db {@code null}.
* /

  *Veza na bazu.
	*private static $db = null;

	*private function __construct() { }
	*private function __clone() { }

	**/
			/*Stvara vezu na bazu ukoliko ona još nije postavljena.
	 */
class DB
{

	private static $db = null;

	private function __construct() { }
	private function __clone() { }
	public static function getConnection()
	{
		if( DB::$db === null )
	    {
	    	try
	    	{
	    		// Unesi ispravni HOSTNAME, DATABASE, USERNAME i PASSWORD
		    	DB::$db = new PDO( "mysql: host=localhost; dbname=Users; charset=utf8", 'root', 'plugyca1' );
		    	//DB::$db = new PDO( "mysql: host=localhost; dbname=server; charset=utf8", 'root', 'mira' );
			    //DB::$db = new PDO( "mysql: host=mysql.hostinger.hr; dbname=u415617757_baza; charset=utf8", 'u415617757_koris', 'pass.mysql' );
			    //DB::$db = new PDO( "mysql: host=rp2.studenti.math.hr; dbname=jukicbraculj; charset=utf8", 'student', 'pass.mysql' );
			    DB::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB::$db;
	}
}

?>
