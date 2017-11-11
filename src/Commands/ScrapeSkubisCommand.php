<?php

namespace MSHACK\DataScraper\Commands;

use MSHACK\DataScraper\Dto\Club;
use MSHACK\DataScraper\Indexer\ElasticSearch;
use MSHACK\DataScraper\Scraper\SkubisScraper;
use MSHACK\DataScraper\Scraper\WnScraper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeSkubisCommand extends Command {

	protected function configure() {
		$this
			->setName('scrape:skubis')
			->setDescription('Scrapes Skubis data')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$skubisScraper = new SkubisScraper();
		$clubs = $skubisScraper->getData();

		/** @var Club $event */
		foreach ($clubs as $event){
			$geodata = $event->transformToGeoData();

			$es = new ElasticSearch();
			$es->transferToIndex($geodata, "");
		}

		$output->writeln(count($clubs)." clubs successfully imported to elestic search");
	}
}