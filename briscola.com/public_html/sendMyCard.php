<?php
include_once dirname(__FILE__) . '/model/db.class.php';
include_once dirname(__FILE__) . '/model/user.class.php';
include_once dirname(__FILE__) . '/controller/dbController.php';

$myCard = $_GET['index'];
$opponent = $_GET['opponent'];

putInWaitAnswer($opponent,$myCard);
echo $_GET['callback'] . '('.json_encode($data).')'; // no $_GET['callback'] . '('. for non-localhost
 ?>
