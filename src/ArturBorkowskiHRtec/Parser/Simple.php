<?php

namespace ArturBorkowskiHRtec\Parser;

class Simple extends AbstractParser implements ParserInterface
{
    const NAME = 'Simple';
    
    public function writeToCsv($items, $nameOfFile)
    {
        $fp = fopen('log/'.$nameOfFile, 'w');
        fputcsv($fp, self::HEADER);
        foreach ($items as $item) { 
            fputcsv($fp, $item); 
        } 
        fclose($fp); 
    }
}
