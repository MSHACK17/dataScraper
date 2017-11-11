#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands

$scrapeWn = new \MSHACK\DataScraper\Commands\ScrapeWnCommand();
$scrapeNews = new \MSHACK\DataScraper\Commands\ScrapeNewsCommand();
$scrapeSkubis = new \MSHACK\DataScraper\Commands\ScrapeSkubisCommand();

$application->add($scrapeWn);
$application->add($scrapeNews);
$application->add($scrapeSkubis);
$application->run();