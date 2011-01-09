# Geckoboard FreeAgent Widget

This repository contains various scripts to generate the appropriate JSON feeds for [FreeAgent](http://fre.ag/32apsc3u) integration with [Geckoboard](geckoboard.com).

Author: Nick Jones (<http://www.nicksays.co.uk>)

# Configuration

All configuration items for this module are held in the config.php file.  The API key specified is not used by FreeAgent, but is used in the Geckoboard widget configuration as a method of authentication.

## Widget Types

The following widgets are available, with more to come in the future.

### Invoice Statistics

![Show invoice statistics on Geckoboard from FreeAgent](http://dl.dropbox.com/u/192363/github/freeagent-geckoboard/freeagent_geckoboard_example.png)

Show your Overdue, Open and Paid invoices as a RAG (Red, Amber and Green) table on your Geckoboard.

#### Widget Parameters

**Widget:** RAG Columns and Numbers
**URL data feed:** {$yourwebsitename}/invoice_stats.php
**API Key:** (defined in your config.php)
**Widget Type:** Custom
**Feed Format:** JSON