<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Pharse\ItemParser;
use Pharse\StringParser;
use Pharse\ParserApplicative;
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

  public function testStringParserSuccess() {
    $stringParser = new StringParser("abc");
    $parseResult = $stringParser->parse("abcdef");
    $expectedResult = $this->listFactory->pure(new Tuple("abc", "def"));

    $this->assertEquals($expectedResult, $parseResult);
  }

  public function testStringParserFailure() {
    $stringParser = new StringParser("abc");
    $parseResult = $stringParser->parse("abdef");
    $expectedResult = $this->listFactory->empty();

    $this->assertEquals($expectedResult, $parseResult);
  }

  public function testStringParserInputTooShort() {
    $stringParser = new StringParser("abc");
    $parseResult = $stringParser->parse("ab");
    $expectedResult = $this->listFactory->empty();

    $this->assertEquals($expectedResult, $parseResult);
  }

  public function testFunctor() {
    $itemParser = new Itemparser();
    $parseResult = $itemParser->map('strToUpper')->parse("abc");
    $expectedResult = $this->listFactory->pure(new Tuple("A", "bc"));

    $this->assertEquals($expectedResult, $parseResult);
  }

  public function testApplicative() {
    $applicative = new ParserApplicative();
    $ff = $applicative->pure(function($arg) { return intval($arg) + 1; });
    $fx = new ItemParser();
    $parser = $ff->apply($fx);
    $actual = $parser->parse("1bc");
    $expected = $this->listFactory->pure(new Tuple(2, "bc"));

    $this->assertEquals($expected, $actual);
  }
}
