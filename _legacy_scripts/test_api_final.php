<?php
$key="AIzaSyDdO8hbR6KZAgItt1U2zlKU6h0b1g-lGRc";
$url="https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$key";
$data=["contents"=>[["parts"=>[["text"=>"hello"]]]]];
$opts=["http"=>["method"=>"POST","header"=>"Content-Type: application/json\r\n","content"=>json_encode($data),"ignore_errors"=>true]];
$ctx=stream_context_create($opts);
$res=file_get_contents($url,false,$ctx);
echo $res;
