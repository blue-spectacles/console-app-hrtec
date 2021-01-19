<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use ArturBorkowskiHRtec\Command\Csv\CsvSimple; 
use ArturBorkowskiHRtec\Command\Csv\CsvExtended;
use ArturBorkowskiHRtec\Parser\CsvFactory;


$application = new Application();
$csvFactory = new CsvFactory;
$application->add(new CsvSimple($csvFactory)); 
$application->add(new CsvExtended($csvFactory));
$application->run();
