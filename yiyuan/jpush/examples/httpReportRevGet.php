<?php
  include_once '../jpush/JPushClient.php';
  
  $master_secret = 'ae0ab015bfd8d961d63bad92';
  $app_key='d62b7bd21d40b1657190a43c';
  $platform = '';
  $apnsProduction = false;

  //echo phpinfo();
  $client = new JPushClient($app_key,$master_secret);
  $msg_ids = '1613113584';
  //$msg_ids = $_GET['msg_ids'];
  //echo $msg_ids;
  $revResult = $client->getReportReceiveds($msg_ids);
  //echo $revResult->getResultStr();
  $msgstr = "123121212121212";
  if($revResult->isOK())
  {
      $msgstr = $revResult->getResultStr();  
  }
  echo $msgstr;

?>
