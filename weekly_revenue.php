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
    "item" => array(),
    "settings" => array(
        "axisx" => array(),
        "axisy" => array(),
        "colour" => 'ff9900'
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
    $date = strtotime("-{$i} weeks");
    $current_week = (int) date("W", $date);
    
    if ($i % 12 == 0) {
        $return['settings']['axisx'][] = date("M y", $date);
    }

    if (!isset($results[$current_week])) {
        $average = 0;
    } else {
        $average = $results[$current_week]['value'] / $results[$current_week]['count'];
    }
    
    if ($average > $max_average) {
        $max_average = $average;
    }
    
    $return['item'][] = (int) $average;
}

$return['settings']['axisy'] = array(
    0,
    number_format($max_average * 0.25),
    number_format($max_average * 0.50),
    number_format($max_average * 0.75),
    number_format($max_average)
);

echo json_encode($return);
