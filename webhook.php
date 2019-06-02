<?php
 
$accessToken = '9Qo0ZYAb7I2E2Mvpo/kvH6WyiymhsDlbC6WNRR49h38RPEST1BikeT6JVWY6XBmF42VBissR7FWnu9z0QZpO//6LEhVNbyRTBziUhHYuAEQ7RgbihBPHUKux37o8kloEckUNV9TvU7RzYX21VE9g7QdB04t89/1O/w1cDnyilFU=';
 $json_string = file_get_contents('php://input');
    $jsonObj = json_decode($json_string);
    $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};     //ReplyToken取得
    $userId = $jsonObj->{"events"}[0]->{"source"}->{"userId"};        //userId取得
    $eventType = $jsonObj->{"events"}[0]->{"type"};  //typeの取得
    if($eventType == "beacon"){
      ResponseLineText( $accessToken, $replyToken, "僕との距離が近づいてきました！！" );
    }
    function ResponseLineText($accessToken,$replyToken,$text){
        $response_format_text = [
          "type" => "text",
          "text" => $text
        ];
        $post_data = [
           "replyToken" => $replyToken,
           "messages" => [$response_format_text]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: 
        application/json; charser=UTF-8','Authorization: Bearer ' . $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);
     }
?> 
