<?php

namespace ArturBorkowskiHRtec\Parser;

class Extended extends AbstractParser implements ParserInterface
{
    const NAME = 'Extended';

    /**
     * writeToCsv
     *
     * @param array $items
     * @param string $nameOfFile
     * @return void
     */
    public function writeToCsv($items, $nameOfFile)
    {
        if(file_exists('log/'. $nameOfFile )) {
            $fp = fopen('log/'.$nameOfFile, 'a');
            foreach ($items as $item) { 
                fputcsv($fp, $item); 
            }
        }
        else {
            $fp = fopen('log/'.$nameOfFile, 'w');
            fputcsv($fp, self::HEADER);
            foreach ($items as $item) { 
                fputcsv($fp, $item); 
            } 
        }
        fclose($fp); 
    }
}
