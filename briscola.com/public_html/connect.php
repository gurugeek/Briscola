<?php
  include_once dirname(__FILE__) . '/model/db.class.php';
  include_once dirname(__FILE__) . '/model/user.class.php';
  include_once dirname(__FILE__) . '/controller/dbController.php';


  //echo "Class is ok";
  $db = DB::getConnection();
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  //echo 'Connected successfully';

  //got nickname and newUser;
  //to be sent
  $data = array();
  if(isset($_GET['nickname'])){

    $nickname = htmlentities($_GET['nickname'], ENT_QUOTES );

    $newUser = (htmlentities($_GET['newUser'], ENT_QUOTES )==='true');
    $data['newUser'] = $newUser;
    //dodaj novog korisnika
    if($newUser == "true"){
      //echo "nick ".$nickname."<br/>";
      $var = existingNickName($nickname);
      //echo "returned".$var."<br/>";
      while($var){
        $nickname = $nickname."".rand(0,9);
        $var = existingNickName($nickname);
      }

      $data['nickname'] = $nickname;
      //db communication
      $user = new User(false,$nickname);
    //  echo $user->nickname." nakon create<br/>";
      $user->put_in_db();

    } else {
      $data['nickname'] = $nickname;
      //echo "Nisam novi trezim para";
    }
    //find opponent
    $play = giveMePair($nickname); // and shuffeled cards in array
    if($play){
      $data['opponent'] = $play['opponent'];
      $data['shuffeledCards'] = $play['shuffeledCards'];
      $data['first'] = $play['first']; //koji sam na redu.
    }


  }

  echo $_GET['callback'] . '('.json_encode($data).')'; // no $_GET['callback'] . '('. for non-localhost
?>
