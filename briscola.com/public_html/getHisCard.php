<?php
include_once dirname(__FILE__) . '/model/db.class.php';
include_once dirname(__FILE__) . '/model/user.class.php';
include_once dirname(__FILE__) . '/controller/dbController.php';

$nickname = $_GET['nickname'];

$data['index'] = getWaitedAnswer($nickname);

echo $_GET['callback'] . '('.json_encode($data).')'; // no $_GET['callback'] . '('. for non-localhost
?>
