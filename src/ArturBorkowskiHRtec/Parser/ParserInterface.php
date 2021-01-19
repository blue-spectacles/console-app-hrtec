<?php

namespace ArturBorkowskiHRtec\Parser;

interface ParserInterface
{
    public function writeToCsv($items, $nameOfFiles);
}
