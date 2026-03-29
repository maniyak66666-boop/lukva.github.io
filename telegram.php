<?php
// telegram.php - Обработчик формы для отправки в Telegram

$token = 8338610711:AAHVcw3y4uiNl8HdgZ8K3YClNAaN3_1-Zro;
$chat_id = 1358915788;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $contact = htmlspecialchars($_POST['contact']);
    $contact_type = htmlspecialchars($_POST['contact_type']);
    $service = htmlspecialchars($_POST['service']);
    $description = htmlspecialchars($_POST['description']);
    
    $message = "🎵 <b>Новый заказ!</b>\n\n";
    $message .= "👤 <b>Имя:</b> " . $name . "\n";
    $message .= "📞 <b>Контакт:</b> " . $contact . "\n";
    $message .= "💬 <b>Тип связи:</b> " . $contact_type . "\n";
    $message .= "🎼 <b>Услуга:</b> " . $service . "\n";
    $message .= "📝 <b>Описание:</b> " . $description . "\n";
    $message .= "\n📅 <b>Дата:</b> " . date("d.m.Y H:i");
    
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>