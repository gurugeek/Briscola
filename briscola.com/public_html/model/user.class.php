<?php
include_once dirname(__FILE__) . '/db.class.php';

class User
{
	public $id, $nickname;

	function __construct( $id, $nickname) //$password), $email, $reg_seq, $has_registered )
	{
		$this->id = $id;
		$this->nickname = $nickname;


	}

	function __get( $prop ) { return $this->$prop; }

	function json_string(){
		return json_encode([$this->$nickname]);
	}
  function put_in_db(){

    $db = DB::getConnection();
    try
    {
    	$st = $db->prepare(
        'INSERT INTO user (nickname) VALUES (:nickname)'
    	);

    	$st->execute(array( 'nickname' => $this->nickname));
    }
    catch( PDOException $e ) { exit( "PDO error kod izrade tablice igre: " . $e->getMessage() ); }

    //echo "user".$this->nickname." created in db.<br />";
  }


  function remove(){
    $db = DB::getConnection();
    try
    {
    	$st = $db->prepare(
        'DELETE FROM user WHERE nickaname=:nickname'
    	);

    	$st->execute(array( 'nickname' => $this->nickname));
    }
    catch( PDOException $e ) { exit( "PDO error kod izrade tablice igre: " . $e->getMessage() ); }

    //echo "user".$this->nickname." removed in db.<br />";
  }
}

?>
