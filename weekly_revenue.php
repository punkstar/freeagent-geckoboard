<?php
error_reporting(E_ALL);

if (file_exists("config.php")) {
    include "config.php";
} else {
    die("Please rename config.example.php to config.php and enter your details to continue.\n");
}

include "functions.php";

check_api($api_key);

$url = "https://{$company}.freeagentcentral.com/invoices.xml?view=last_12_months";

$xml = perform_xml_request($url, $username, $password);

$results = array();
$return = array(
    "items" => array(),
    "settings" => array(
        "axisx" => array(),
        "axisy" => array()
    )
);

foreach ($xml->invoice as $invoice) {
    $status = strtolower($invoice->status);
    $value  = $invoice->{'net-value'};
    $week   = (int) date("W", strtotime($invoice->{'dated-on'}));

    if (!isset($results[$week])) {
        $results[$week] = array(
            "value" => 0,
            "count" => 0
        );
    }
    
    $results[$week]['value'] += $value;
    $results[$week]['count']++;
}

$max_average = 0;

for ($i = 0; $i < 52; $i++) {
    $current_week = (int) date("W", strtotime("-{$i} weeks"));
    
    $return['settings']['axisx'][] = $current_week;
    
    if (!isset($results[$current_week])) {
        $average = 0;
    } else {
        $average = $results[$current_week]['value'] / $results[$current_week]['count'];
    }
    
    if ($average > $max_average) {
        $max_average = $average;
    }
    
    $return['items'][] = (int) $average;
}

$return['settings']['axisy'] = array(
    0, $max_average
);

echo json_encode($return);