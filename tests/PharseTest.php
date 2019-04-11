<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Pharse\ItemParser;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class PharseTest extends TestCase {

  private $listFactory;

  protected function setUp() {
    $this->listFactory = new LinkedListFactory();
  }

  public function testItemParser() {
    $itemParser = new Itemparser();
    $parseResult = $itemParser->parse("abc");
    $expectedResult = $this->listFactory->pure(new Tuple("a", "bc"));

    $this->assertEquals($expectedResult, $parseResult);
  }

  public function testFunctor() {
    $itemParser = new Itemparser();
    $parseResult = $itemParser->map('strToUpper')->parse("abc");
    $expectedResult = $this->listFactory->pure(new Tuple("A", "bc"));

    $this->assertEquals($expectedResult, $parseResult);
  }
}
