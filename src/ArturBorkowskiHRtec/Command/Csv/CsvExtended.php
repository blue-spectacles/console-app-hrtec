<?php

namespace ArturBorkowskiHRtec\Command\Csv;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ArturBorkowskiHRtec\Parser\CsvFactory;

class CsvExtended extends Command
{
    const EXTENDED = 'Extended';

    public $csvFactory;

    public function __construct(CsvFactory $csfFactory)
    {
        parent::__construct();
        $this->csvFactory = $csfFactory;
    }

    protected function configure()
    {
        $this
            ->setName('csv:extended')
            ->setDescription('Fetch content')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Remote url'
            )
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Name of file'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $nameOfFile = $input->getArgument('path');

        try {
                $parser = $this->csvFactory->getParser(self::EXTENDED);
                $xml = $parser->getResponse($url);
                $items = $parser->getContent($xml);
                $parser->writeToCsv($items, $nameOfFile);
                $output->writeln([
                'Items wrote to extended_export.csv file :-)',
                '============',
                '',
                ]);
                return Command::SUCCESS;

        } catch (\InvalidArgumentException $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }
    }
}