<?php

namespace ArturBorkowskiHRtec\Parser;

use GuzzleHttp\Client;

abstract class AbstractParser 
{
    const HEADER = ['title', 'description', 'link', 'pubData', 'creator'];

    /**
     * getResponse
     *
     * @param string $url
     * @return object
     */
    public function getResponse($url) 
    {
        $client = new Client;
        $response = $client->request('GET', $url);
        $body = $response->getBody();
        $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $xml;
    }

    /**
     * getRssCreator
     *
     * @param $xml
     * @return array
     */
    protected function getRssCreator($xml) : array
    {
        $rssCreator = [];
        foreach ($xml->channel->item as $item) 
        {
            $dc = $item->children('http://purl.org/dc/elements/1.1/');
            $rssCreator[] = (array)$dc->creator;
        }

        return $rssCreator;
     }

     /**
      * removeHtml
      *
      * @param string $description
      * @return string
      */
     protected function removeHtml($description) : string
     {
        return strip_tags($description);
     }

     /**
      * convertPubDate
      *
      * @param string $date
      * @return string
      */
     public function convertPubDate($date) : string
     {
        $date=date_create($date);
        $polishMonths = [
            'January' => 'Styczeń',
            'February' => 'Luty',
            'March' => 'Marzec',
            'April' => 'Kwiecień',
            'May' => 'May',
            'June' => 'Czerwiec',
            'July' => 'Lipiec',
            'August' => 'Sierpień',
            'September' => 'Wrzesień',
            'October' => 'Październik',
            'November' => 'Listopad', 
            'December' => 'Grudzień'
        ];
        $formated = date_format($date,"d F Y H:i:s");
        $arrayFormated = explode(' ', $formated);
        $arrayFormated[1] = $polishMonths[$arrayFormated[1]];
        return implode(' ', $arrayFormated);
    }

     /**
      * getContent
      *
      * @param $xml
      * @return array
      */
     public function getContent($xml) : array
     {
        $rssCreator = $this->getRssCreator($xml);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $items = [];
        $index = 0;
        foreach($array['channel']['item'] as $row)
        {
            $items[] = [
                'title' => $row['title'],
                'description' => $this->removeHtml($row['description']),
                'link' => $row['link'],
                'pubDate' => $this->convertPubDate($row['pubDate']), 
                'creator' => $rssCreator[$index][0]
            ];
            $index++;
        }
        return $items;
     }
}
