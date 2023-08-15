<?php

// Функция для проверки наличия номера в Telegram
function checkTelegram($phone_number): bool
{
    $bot_token = $_ENV["TELEGRAM_BOT_TOKEN"];
    $telegram_api_url = "https://api.telegram.org/bot$bot_token/getChat?chat_id=$phone_number";

    // Отправляем запрос и получаем ответ
    $response = file_get_contents($telegram_api_url);

    if ($response === false) {
        // Обработка ошибки при запросе к API
        $error_message = "Ошибка при запросе к API Telegram";
        error_log($error_message); // Логгируем ошибку
        return false;
    }

    $data = json_decode($response, true);

    // Проверяем наличие поля 'ok' и его значение
    return isset($data['ok']) && $data['ok'] === true;
}

// Функция для отправки сообщения в Telegram
function send_telegram_message($phone_number, $message): bool|string
{
    $bot_token = $_ENV["BOT_TOKEN"];
    $telegram_api_url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$phone_number&text=" . urlencode($message);

    // Отправляем запрос и получаем ответ
    $response = file_get_contents($telegram_api_url);

    if ($response === false) {
        // Обработка ошибки при запросе к API
        $error_message = "Ошибка при запросе к API Telegram";
        error_log($error_message); // Логгируем ошибку
        return false;
    }

    return $response;
}
