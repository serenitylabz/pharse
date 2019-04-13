<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Pharse\ItemParser;
use Pharse\ParserApplicative;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserApplicativeTest extends TestCase {

  private $listFactory;

  protected function setUp() {
    $this->listFactory = new LinkedListFactory();
  }

  public function testApplicative() {
    $applicative = new ParserApplicative();
    $ff = $applicative->pure(function($arg) { return intval($arg) + 1; });
    $fx = new ItemParser();
    $parser = $applicative->apply($ff, $fx);
    $actual = $parser->parse("1bc");
    $expected = $this->listFactory->pure(new Tuple(2, "bc"));

    $this->assertEquals($expected, $actual);
  }
}
