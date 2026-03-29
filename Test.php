<?php
$token = "8338610711:AAHVcw3y4uiNl8HdgZ8K3YClNAaN3_1-Zro";
$chat_id = "1358915788";
$url = "https://api.telegram.org/bot{$token}/getMe";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>