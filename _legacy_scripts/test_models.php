<?php
$key="AIzaSyAnBUtrO4qaX2A3BSRU3Gak_vuKSvEpedM";
$url="https://generativelanguage.googleapis.com/v1beta/models?key=$key";
$opts=["http"=>["method"=>"GET","ignore_errors"=>true]];
$ctx=stream_context_create($opts);
$res=file_get_contents($url,false,$ctx);
echo $res;
