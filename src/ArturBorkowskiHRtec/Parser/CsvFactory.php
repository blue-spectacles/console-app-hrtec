<?php 

namespace ArturBorkowskiHRtec\Parser;

class CsvFactory implements CsvFactoryInterface
{
    public function getParser($name)
    {
        $parser = 'ArturBorkowskiHRtec\\Parser\\'.$name;
        return new $parser;
    }
}
