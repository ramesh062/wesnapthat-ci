<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function send_message($number,$body)
{
    $fromNunber="+447729132830";
    $ID = 'ACa15891e50131f86206825cc727e2dead';
    $token = 'e9e6f3389d7d644389d434e89995a832';
    $messageService='MG35828a596a8a9312fc1c18cba60a51e0';
    $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $ID . '/Messages.json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

    curl_setopt($ch, CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD,$ID . ':' . $token);

    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        'To=' . rawurlencode($number) .
        // '&From=' . rawurlencode($fromNunber) .
        '&Body=' . rawurlencode($body).
        '&MessagingServiceSid=' . rawurlencode($messageService)
        );

    $resp = curl_exec($ch);
    curl_close($ch);
    return json_decode($resp,true);
}
