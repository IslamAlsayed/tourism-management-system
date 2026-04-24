<?php
$json = file_get_contents('translation_export_raw.json');
$data = json_decode($json, true);
echo implode(', ', array_keys($data));
