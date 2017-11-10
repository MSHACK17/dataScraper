#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands

$scrape = new \MSHACK\DataScraper\Commands\ScrapeCommand();

$application->add($scrape);
$application->run();