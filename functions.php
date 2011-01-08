<?php

function perform_xml_request($url, $username, $password) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSLVERSION,     3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH,       CURLAUTH_BASIC) ;
    curl_setopt($ch, CURLOPT_USERPWD,        "{$username}:{$password}");
    curl_setopt($ch, CURLOPT_URL,            $url);

    $data = curl_exec($ch);

    curl_close($ch);

    $xml = simplexml_load_string($data);
    
    return $xml;
}

function check_api($api_key) {
    // Check iff we're using the cli
    if (isset($_SERVER['REMOTE_ADDR'])) {
        if (empty($api_key)) {
            die("Please enter an API key in config.php.\n");
        } else if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != $api_key) {
            header("HTTP/1.1 403 Access denied");
            die("Invalid API key\n");
        }
    }
}