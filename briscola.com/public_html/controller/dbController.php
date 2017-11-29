<?php
include_once dirname(__DIR__).'/model/db.class.php';

/**
*Returns all users from the users list.
*Array of query rows.
*Each row $row contains 'id' amd 'nickname' which can be accesed
*$['id'], $row['nickaname'].
*/
function getAllUsers(){
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  try{
    //echo "traaa<br/>";
    $st = $db->prepare('SELECT * FROM user');
    $st->execute();
    $results = $st->fetchAll();
    $st->closeCursor();

    foreach($results as $r){
            //echo $r['nickname'] . '<br />';
    }
    return $results;

  } catch( PDOException $e )
    { echo  "PDO error kod izrade tablice igre: "
      . $e->getMessage(); }
}
/**
*Returns the play of the user with $nickname1.
*Row $row contains 'id' and 'player1' and 'player2' and 'shuffeledCards' and
*'first' which indicates if the 'player1' is on turn, which can be accesed
*$row['entety name'].
*/
function getPlay($nickname1){
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  $play = false;
  try{
    //echo gettype($nickname1)."traaa<br/>";
    //$st = $db->prepare('SELECT * FROM playing WHERE player1:=player1');
    $st = $db->prepare('SELECT * FROM playing');
    $st->execute();
    //$st->execute(array( 'player1' => "Karlo"));
    $results = $st->fetchAll();
    $st->closeCursor();

    foreach($results as $r){
            if($nickname1 == $r['player1'] ){
              //echo $r['player2'] . '<br />';
              $play = $r;
            }
    }

    return $play;

  } catch( PDOException $e )
    { echo  "PDO error kod izrade tablice igre: "
      . $e->getMessage(); }
}

/**
*Puts 2 users into playing list.
*/
function put_in_play($player1,$player2,$shuffeledCards){

  $db = DB::getConnection();
  try
  {
    $st = $db->prepare(
      'INSERT INTO playing (player1,player2,shuffeledCards,first)'.
      ' VALUES (:player1,:player2,:shuffeledCards,:first)'
    );

    $st->execute(array( 'player1' => $player1,
                    'player2' => $player2,
                    'shuffeledCards' => $shuffeledCards,
                    'first' => true
                  ));
    $st->execute(array( 'player1' => $player2,
                                  'player2' => $player1,
                                  'shuffeledCards' => $shuffeledCards,
                                  'first' => false
                                ));
  }
  catch( PDOException $e ) { exit( "PDO error kod izrade playing igre: " . $e->getMessage() ); }



  //echo "user".$player1." play in playing.<br />";
}
/**
*Returns all users from the witing list.
*Array of query rows.
*Each row $row contains 'id' amd 'nickname' which can be accesed
*$['id'], $row['nickaname'].
*/
function getWaitList(){
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  try{
    //echo "traaa<br/>";
    $st = $db->prepare('SELECT * FROM waitList');
    $st->execute();
    $results = $st->fetchAll();
    $st->closeCursor();

    foreach($results as $r){
            //echo $r['nickname'] . '<br />';
    }
    return $results;

  } catch( PDOException $e )
    { echo  "PDO error kod izrade tablice igre: "
      . $e->getMessage(); }
   return false;
}
/**
*Puts user $nickname into witing list.
*/
function put_in_waitList($nickname){

  $db = DB::getConnection();
  try
  {
    $st = $db->prepare(
      'INSERT INTO waitList (nickname) VALUES (:nickname)'
    );

    $st->execute(array( 'nickname' => $nickname));
  }
  catch( PDOException $e ) { exit( "PDO error kod izrade tablice igre: " . $e->getMessage() ); }

  //echo "user".$nickname." created in waitList.<br />";
}

/**
*Removes user $nickname from the waiting list.
*/
function remove_from_waitList($nickname){

  $db = DB::getConnection();
  try
  {
    $st = $db->prepare(
      'DELETE FROM waitList WHERE nickname=:nickname'
    );

    $st->execute(array( 'nickname' => $nickname));
  }
  catch( PDOException $e ) { exit( "PDO error kod izrade tablice igre: " . $e->getMessage() ); }

  //echo "user".$nickname." deleted in waitList.<br />";
}
/**
*Put the thrown card of the opponent of the $opponent in ths round.
*index is the index of array hisCards[](on opponent client)
*which contains the number or real cards*-in
*the deck which is thrown.
*/
/**
*Call for opponent that the card of his opponent is thrown.
*/
function putInWaitAnswer($opponent,$thrownCard){
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  try{
    //echo "traaa<br/>";
    $st = $db->prepare(
      'INSERT INTO waitAnswer (id,thrownCard)'.
      ' VALUES (:id,:thrownCard)'
    );
    $st->execute(array('id' => $opponent,
            'thrownCard' => $thrownCard));
    $st->closeCursor();

    foreach($results as $r){
            //echo $r['nickname'] . '<br />';
    }
    return true; //it is inserted
  } catch( PDOException $e )
    { echo  "PDO error kod izrade tablice igre: "
      . $e->getMessage(); }
}

/**
*If the opponent from $nickname has played, the index in hisCard[]
*which he has plaed is returned.
*Othervise false is returned. Just index of thrown card is return.
*/
function getWaitedAnswer($nickname){
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  try{
    //echo "traaa<br/>";
    $st = $db->prepare(
      'SELECT * FROM waitAnswer WHERE id=:id'
    );
    $st->execute(array('id' => $nickname));
    $results = $st->fetchAll();
    $st->closeCursor();

    foreach($results as $r){
            $st = $db->prepare(
              'DELETE FROM waitAnswer WHERE id=:nickname'
            );

            $st->execute(array( 'nickname' => $nickname));
            return $r['thrownCard'];
    }
    return false;

  } catch( PDOException $e )
    { echo  "PDO error kod izrade tablice igre: "
      . $e->getMessage(); }
}

/**
*Does my nick exists.
*/
function existingNickName($nickname){
  $results = getAllUsers();
  foreach($results as $r){
          if($r['nickname']==$nickname)
            return true;
  }
  return false;
}

/**
*Select my pai from the users in waiting list.
*/
function giveMePair($nickname){
  $data = array();

  $results = getWaitList();
  //proleti po uparenima.!!!
  $play = getPlay($nickname); //just one
  //echo $play['player2'];
  if(!empty($play)){
    $data['opponent'] = $play['player2'];
    $data['shuffeledCards'] = $play['shuffeledCards'];
    $data['first'] = $play['first'];
    remove_from_waitList($nickname);
    return $data;
  }

  if(empty($results)){
    put_in_waitList($nickname);//add me if it is mepty
    return false;
  } else {
    foreach($results as $r){
            $opponent = $r['nickname'];
            //echo $results[0];
    }
    if(isset($opponent) && ($opponent !== $nickname)){
      remove_from_waitList($opponent);
      $numbers = range(0, 39);
      shuffle($numbers);
      $cards = json_encode($numbers);
      put_in_play($nickname,$opponent,$cards);
      $data['opponent'] = $opponent;
      $data['shuffeledCards'] = $cards;
      $data['first'] = "1";
      return $data;
    }
    return false;//if thats me, do not return me,

  }

  return false;
}
//echo getAllUsers();


?>
