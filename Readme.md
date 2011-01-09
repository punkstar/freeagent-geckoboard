# Geckoboard FreeAgent Widget

This repository contains various scripts to generate the appropriate JSON feeds for [FreeAgent](http://fre.ag/32apsc3u) integration with [Geckoboard](geckoboard.com).

Author: Nick Jones (<http://www.nicksays.co.uk>)

# Configuration

All configuration items for this module are held in the config.php file.  **Note:** The API key specified is not used by [FreeAgent](http://fre.ag/32apsc3u), but is used in the [Geckoboard](geckoboard.com) widget configuration as a method of authentication.  It's just a random string, secret to only Geckoboard and your configuration file.

## Invoice Statistics

Show your Overdue, Open and Paid invoices, from the last three months, as a RAG table on your [Geckoboard](geckoboard.com).

### Widget Preview

![Show invoice statistics on Geckoboard from FreeAgent](http://dl.dropbox.com/u/192363/github/freeagent-geckoboard/freeagent_geckoboard_example.png)

### Widget Parameters

* **Widget:** RAG Columns and Numbers
* **URL data feed:** {$yourwebsitename}/invoice_stats.php
* **API Key:** (defined in your config.php)
* **Widget Type:** Custom
* **Feed Format:** JSON

## Weekly Revenue

Show your weekly invoiced totals on your [Geckoboard](geckoboard.com) as a line graph.

### Widget Preview

![Show weekly revenue as a sparkline on Geckoboard from FreeAgent](http://dl.dropbox.com/u/192363/github/freeagent-geckoboard/freeagent_geckoboard_example_weekly_stats.png)

### Widget Parameters

* **Widget:** Line Chart (2x1 looks cool)
* **URL data feed:** {$yourwebsitename}/weekly_revenue.php
* **API Key:** (defined in your config.php)
* **Widget Type:** Custom
* **Feed Format:** JSON
