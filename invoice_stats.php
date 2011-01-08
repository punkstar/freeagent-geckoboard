<?php
error_reporting(E_ALL);

if (file_exists("config.php")) {
    include "config.php";
} else {
    die("Please rename config.example.php to config.php and enter your details to continue.\n");
}

include "functions.php";

check_api($api_key);

$url = "https://{$company}.freeagentcentral.com/invoices.xml?view=last_3_months";

$xml = perform_xml_request($url, $username, $password);

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
            "value" => "Overdue",
            "text"  => $results['overdue']
        ),
        array(
            "value" => "Open",
            "text"  => $results['open']
        ),
        array(
            "value" => "Paid",
            "text"  => $results['paid']
        )
    )
);

echo json_encode($output);
