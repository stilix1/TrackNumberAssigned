<?php
// Подключение Библиотек
require_once 'vendor/autoload.php';

// Проверка наличия аккаунта в WhatsApp
function checkWhatsApp($recipient): bool
{
    // TWILIO ACCOUNT_SID, AUTH_TOKEN указываются в $_ENV
    $accountSid = $_ENV['ACCOUNT_SID'];
    $authToken = $_ENV['AUTH_TOKEN'];

    $twilio = new Twilio\Rest\Client($accountSid, $authToken);

    try {
        $message = $twilio->messages->create(
            "whatsapp:$recipient",
            array(
                "from" => "whatsapp:+" . $_ENV['TWILIO_PHONE_NUMBER'], // TWILIO_PHONE_NUMBER указывается в $_ENV
                "body" => ""
            )
        );
        return strpos($message->body, 'sent via WhatsApp') !== false;
    } catch (Exception $e) {
        return false;
    }
}

// Функция отправки сообщения в WhatsApp
function send_whatsapp_message($recipient, $msg): ?string
{
    // Указать в env AccountSID, AuthToken
    $accountSid = $_ENV['ACCOUNT_SID'];
    $authToken = $_ENV['AUTH_TOKEN'];

    $twilio = new Twilio\Rest\Client($accountSid, $authToken);

    $message = $twilio->messages->create(
        "whatsapp:$recipient",
        array(
            "from" => "whatsapp:+" . $_ENV['TWILIO_PHONE_NUMBER'],
            "body" => $msg
        )
    );

    return $message->sid;
}