<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Pharse\ItemParser;
use Pharse\ParserFunctor;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserFunctorTest extends TestCase {

  private $listFactory;

  protected function setUp() {
    $this->listFactory = new LinkedListFactory();
  }

  public function testFunctor() {
    $functor = new ParserFunctor();
    $itemParser = new Itemparser();
    $parseResult = $functor->map($itemParser, 'strtoupper')->parse("abc");
    $expectedResult = $this->listFactory->pure(new Tuple("A", "bc"));

    $this->assertEquals($expectedResult, $parseResult);
  }
}
