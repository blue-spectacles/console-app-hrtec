<?php

namespace ArturBorkowskiHRtec\Command\Csv;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ArturBorkowskiHRtec\Parser\CsvFactory;

class CsvSimple extends Command
{
    const SIMPLE = 'Simple';

    public $csvFactory;

    public function __construct(CsvFactory $csfFactory)
    {
        parent::__construct();
        $this->csvFactory = $csfFactory;
    }

    protected function configure()
    {
        $this
            ->setName('csv:simple')
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
            $parser = $this->csvFactory->getParser(self::SIMPLE);
            $xml = $parser->getResponse($url);
            $items = $parser->getContent($xml);
            $parser->writeToCsv($items, $nameOfFile);
            $output->writeln([
                'Items wrote to simple_export.csv file :-)',
                '============',
                '',
            ]);
            return Command::SUCCESS;
            
        } catch (\InvalidArgumentException $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }
    }
}