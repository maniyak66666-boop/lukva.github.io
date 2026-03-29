<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$token = "8338610711:AAF35TG91X74XW1k4gVSbzbGcq4ZYyzr50A";
$chat_id = "1358915788";

// Проверка токена
$url = "https://api.telegram.org/bot{$token}/getMe";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h3>Проверка токена:</h3><pre>";
print_r(json_decode($response, true));
echo "</pre>";

// Проверка возможности отправки
echo "<h3>Тест отправки:</h3>";
$testUrl = "https://api.telegram.org/bot{$token}/sendMessage";
$testData = [
    'chat_id' => $chat_id,
    'text' => '✅ Тест: бот работает!'
];
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $testUrl);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($testData));
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$testResult = curl_exec($ch2);
curl_close($ch2);
echo "<pre>";
print_r(json_decode($testResult, true));
echo "</pre>";
?>
