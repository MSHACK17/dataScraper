<?php

namespace MSHACK\DataScraper\Commands;

use MSHACK\DataScraper\Scraper\WnScraper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeCommand extends Command {

	protected function configure() {
		$this
			->setName('scrape:wn')
			->setDescription('Scrapes WN event data')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$wnScraper = new WnScraper();
		$wnEvents = $wnScraper->getData();
	}
}