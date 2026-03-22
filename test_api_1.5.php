<?php
$key="AIzaSyASEsgdJa-tSmwdSGV0O87xxRPU8dnTuKI";
$url="https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$key";
$data=["contents"=>[["parts"=>[["text"=>"test"]]]]];
$opts=["http"=>["method"=>"POST","header"=>"Content-Type: application/json\r\n","content"=>json_encode($data),"ignore_errors"=>true]];
$ctx=stream_context_create($opts);
$res=file_get_contents($url,false,$ctx);
echo $res;
