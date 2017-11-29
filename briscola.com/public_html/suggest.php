<?php
session_start();

$imena = [ "Ana", "Ante", "Boris", "Maja", "Marko", "Mirko", "Slavko", "Slavica" ];
$q =  htmlentities($_GET['q'], ENT_QUOTES );
if(!isset($_SESSION['w']))
  $_SESSION['w'] = array();//create waiting list if there is no one.


//data to be sent
$data = array();
if(!((empty($q) && $q == 0) || trim($q) == false)){
  $options = "";
  foreach( $imena as $ime )
      if( strpos( $ime, $q ) !== false ){
          $options = $options."<option value='" . $ime . "' />\n";
        }
  //echo $options;
  $data['options'] = $options;
} else {
  if(isset($_GET['nickname'])){
    $nickname = htmlentities($_GET['nickname'], ENT_QUOTES );

    //localStorage['nickname'] = data.nickname;
    //localStorage['opponent'] = data.opponent;
    $newUser = htmlentities($_GET['newUser'], ENT_QUOTES );
    $data['newUser'] = $newUser;
    //dodaj novog korisnika
    if($newUser){
      while(in_array($nickname, $_SESSION['playing'], true)){
        $nickname = $nickname."".rand(0,9);
      }
    }
    $data['nickname'] = $nickname;
    if(empty($_SESSION['w'])){
      //store connesction
      array_unshift($_SESSION['w'],$nickname);
    } else {
      $data['opponent'] = array_pop($_SESSION['w']);
    }
  }
  //echo "";
}
$data['w'] = $_SESSION;
echo $_GET['callback'] . '('.json_encode($data).')'; // no $_GET['callback'] . '('. for non-localhost

?>
