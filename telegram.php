<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Удалить после настройки!

$token = "8338610711:AAHVcw3y4uiNl8HdgZ8K3YClNAaN3_1-Zro"; 
$chat_id = "1358915788";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars(trim($_POST['contact'] ?? ''), ENT_QUOTES, 'UTF-8');
    $contact_type = htmlspecialchars(trim($_POST['contact_type'] ?? 'Telegram'), ENT_QUOTES, 'UTF-8');
    $service = htmlspecialchars(trim($_POST['service'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($name) || empty($contact)) {
        echo json_encode(['success' => false, 'error' => 'Заполните обязательные поля']);
        exit;
    }

    $message = "🎵 <b>Новый заказ!</b>\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "👤 <b>Имя:</b> " . $name . "\n";
    $message .= "📞 <b>Контакт:</b> " . $contact . "\n";
    $message .= "💬 <b>Тип связи:</b> " . $contact_type . "\n";
    $message .= "🎼 <b>Услуга:</b> " . $service . "\n";
    $message .= "📝 <b>Описание:</b> " . $description . "\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "📅 <b>Дата:</b> " . date("d.m.Y H:i");

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $result = curl_exec($ch);
    
    // Отладка: если ошибка cURL
    if ($result === false) {
        error_log("CURL Error: " . curl_error($ch));
        echo json_encode(['success' => false, 'debug' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Отладка: вывод ответа Telegram
    $response = json_decode($result, true);
    if ($response && $httpCode == 200 && ($response['ok'] ?? false)) {
        echo json_encode(['success' => true]);
    } else {
        error_log("Telegram API Error: " . $result);
        echo json_encode(['success' => false, 'debug' => $response]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Неверный метод запроса']);
}
?>