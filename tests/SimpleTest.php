<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ArturBorkowskiHRtec\Parser\Simple;

final class SimpleTest extends TestCase
{
   public $simple;
   public $date;

   public function setUp() : void
   {
      $this->simple = new Simple;
      $this->date = '19 January 2021 16:00:00';
   }

   public function testIsSimpleObject() 
   {
      $this->assertInstanceOf(Simple::class, $this->simple); 
   }

   public function testConvertPubDate() 
   {
       $this->assertEquals('19 Styczeń 2021 16:00:00', $this->simple->convertPubDate($this->date));
   }
}