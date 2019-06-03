<?php
 $accessToken = 'アクセストークン';
 $json_string = file_get_contents('php://input');
    $jsonObj = json_decode($json_string);
    $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};     //ReplyToken取得
    $userId = $jsonObj->{"events"}[0]->{"source"}->{"userId"};        //userId取得
    $eventType = $jsonObj->{"events"}[0]->{"type"};  //typeの取得
$message_type = $jsonObj->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
$message_text = $jsonObj->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
    if($eventType == "beacon"){
      ResponseLineText( $accessToken, $replyToken, "近くにビーコンがあります！！" );
    }
if($message_type == "text"){
$return_message_text = "「" . $message_text . "」??";
sending_messages($accessToken, $replyToken, $message_type, $return_message_text);}

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

function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];
 
    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];
 
    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}
?> 
