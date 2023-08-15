<?php

// Подключение скрипты для работы с мессенджерами
require_once 'twilio_whatsapp.php';
require_once 'telegramAPI.php';


/**
 * Отправляет уведомление о статусе "Присвоен трек-номер" мерчанту через мессенджер (WhatsApp или Telegram).
 *
 * @param int $order_id Номер заказа, для которого изменяется статус.
 * @param string $phone_number Номер телефона мерчанта.
 */
function send_track_number_assigned_status($order_id, $phone_number) {
    // Формируем сообщение о статусе заказа
    $message = "Статус заказа $order_id изменен на 'Присвоен трек-номер'. Накладная на отправку находится в вашем личном кабинете, в заказе, раздел 'Прикрепленные файлы'.";

    // Проверяем, наличие номера в месенджерах
    try {
        // Проверка наличия в WhatsApp
        if (checkWhatsApp($phone_number)) {
            send_whatsapp_message($phone_number, $message);
        }
        // Иначе, проверяем, есть ли номер Telegram
        elseif (checkTelegram($phone_number)) {
            send_telegram_message($phone_number, $message);
        }
        // Если номер не найден =  выбрасывается ошибка "Номер не найден"
        else {
            throw new Exception('Номер не найден');
        }
    }catch (Exception $e) {
        print($e);
    }
}

// Вызов функции, в дальнейшем может быть интегрирована в UI админ панели.
send_track_number_assigned_status(123, '+12345678910');