<?php
error_reporting(E_ALL);

if (file_exists("config.php")) {
    include "config.php";
} else {
    die("Please rename config.example.php to config.php and enter your details to continue.\n");
}

if (empty($api_key)) {
    die("Please enter an API key in config.php.\n");
} else if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != $api_key) {
    header("HTTP/1.1 403 Access denied");
    die("Invalid API key\n");
}

$url = "https://{$company}.freeagentcentral.com/invoices.xml?view=recent_open_or_overdue";

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

$results = array(
    "open"    => 0,
    "overdue" => 0,
    "paid"    => 0
);

foreach ($xml->invoice as $invoice) {
    $status = strtolower($invoice->status);
    $value  = $invoice->{'net-value'};
    
    switch ($status) {
        case "open":
        case "overdue":
        case "paid":
            $results[$status] += (float) $value;
            break;
    }
}

$output = array(
    "item" => array(
        array(
            "text" => "Overdue",
            "value"  => $results['overdue']
        ),
        array(
            "text" => "Open",
            "value"  => $results['open']
        ),
        array(
            "text" => "Paid",
            "value"  => $results['paid']
        )
    )
);

// print_r($output);
echo json_encode($output);
