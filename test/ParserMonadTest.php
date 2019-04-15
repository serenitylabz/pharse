<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Pharse\ItemParser;
use Pharse\NItemParser;
use Pharse\ParserMonad;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserMonadTest extends TestCase {

  private $listFactory;

  protected function setUp() {
    $this->listFactory = new LinkedListFactory();
  }

  public function testMonad() {
    $monad = new ParserMonad();
    $intParser = (new ItemParser())->map(function($s) { return intval($s); });
    $f = function($i) {
      return new NItemParser($i);
    };
    $parser = $monad->flatMap($intParser, $f);
    $actual = $parser->parse("3bcdefg");
    $expected = $this->listFactory->pure(new Tuple("bcd", "efg"));

    $this->assertEquals($expected, $actual);
  }
}
