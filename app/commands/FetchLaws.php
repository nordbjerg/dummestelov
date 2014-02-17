<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sunra\PhpSimple\HtmlDomParser;

class FetchLaws extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'laws:fetch';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch laws from retsinfo.dk and store them in the database.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// TODO: Refactor!
		Eloquent::unguard();

		$page = 1;
		do {
			$this->info("Processing page {$page}...");
			$url = "https://www.retsinformation.dk/Forms/R0210.aspx?page={$page}";

			$dom = HtmlDomParser::file_get_html($url);

			foreach($dom->find('table#ctl00_MainContent_ResultGrid1 tr') as $law) {
				// Skip the header
				if(stristr($law->class, 'th') !== false) continue;

				// Get the info
				$link = $law->find('a', 0)->href;
				$no = trim($law->children(0)->plaintext);
				$title = trim($law->children(1)->plaintext);
				$ministry = trim($law->children(2)->plaintext);
				$signed = trim($law->children(3)->plaintext);

				// Cool stuff
				$this->info("#{$no} {$title} by {$ministry} signed on {$signed}");

				// Create the law
				$law = Law::create(array(
					'name' => $title,
					'ministry' => $ministry,
				));

				// Parse sections
				$content = HtmlDomParser::file_get_html('https://www.retsinformation.dk/'.$link);
				foreach($content->find('.Paragraf') as $section) {
					// tilføj stk og liste1
					$extra = '';
					$t = $section->next_sibling();
					while(($t = $t->next_sibling())) {
						if(strtolower($t->class) == 'paragraf') break;
						if(in_array(strtolower($t->class), array('stk2', 'liste1'))) continue;

						$extra .= $t;
					}

					Section::create(array(
						// fjern paragraftegn og . fra paragraf
						// TODO: flyt til mutator
						'number' => trim(str_replace(array('§', '.', '&nbsp;'), '', $section->find('.ParagrafNr', 0)->plaintext)),
						// TODO: fjern paragraf fra content
						// TODO: flyt til mutator
						'content' => $section.$extra,
						'law_id' => $law->id,
					));
				}

				// TODO: Check if law already exists
				// NOTE: Laws do not change - if they do, retsinfo.dk will delete them and create a new law
				// this makes it easy to check if a law exists or not - and if a law has changed or not.
				// If the law changed, we delete the old one using the delete cron, and we create the new one.
			}

			// Next page, please.
			$page++;
		} while(trim($dom->find('td.right', 0)->plaintext) !== '&nbsp;');

		$this->info('Done.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
