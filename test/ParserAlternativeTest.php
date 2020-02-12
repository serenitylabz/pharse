<?php

namespace Pharse\Test;

require_once __DIR__ . "/../vendor/serenitylabs/phatcats/test/Typeclass/Alternative/AlternativeTest.php";
use PhatCats\Test\Typeclass\Alternative\AlternativeTest;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;
use Pharse\ParserAlternative;
use Pharse\StringParser;

class ParserAlternativeTest extends AlternativeTest {

  private $parserAlternative;
  private $listFactory;

  public function setUp() {
    $this->parserAlternative = ParserAlternative::getInstance();
    $this->listFactory = new LinkedListFactory();
    parent::setUp();
  }

  protected function getAlternative() {
    return $this->parserAlternative;
  }

  protected function getOne() {
    return $this->parserAlternative->pure(1);
  }

  protected function getTwo() {
    return $this->parserAlternative->pure(2);
  }

  protected function getThree() {
    return $this->parserAlternative->pure(3);
  }

  public function testFirstSuccess() {
    $parseA = new StringParser("a");
    $parseB = new StringParser("b");
    $parser = $this->parserAlternative->or($parseA, $parseB);
    $result = $parser->parse("abc");

    $this->assertTrue(!$result->isEmpty());
  }

  public function testSecondSuccess() {
    $parseA = new StringParser("a");
    $parseB = new StringParser("b");
    $parser = $this->parserAlternative->or($parseB, $parseA);
    $result = $parser->parse("abc");

    $this->assertTrue(!$result->isEmpty());
  }

  public function testZeroOrMore1() {
    $parseA = new StringParser("a");
    $parser = $this->parserAlternative->zeroOrMore($parseA);
    $result = $parser->parse("abc");

    // expected
    $as = $this->listFactory->pure("a");
    $expected = $this->listFactory->pure(new Tuple($as, "bc"));

    $this->assertEquals($expected, $result);
  }

  public function testZeroOrMore2() {
    $parseA = new StringParser("a");
    $parser = $this->parserAlternative->zeroOrMore($parseA);
    $result = $parser->parse("bcd");

    // expected
    $as = $this->listFactory->empty();
    $expected = $this->listFactory->pure(new Tuple($as, "bcd"));

    $this->assertEquals($expected, $result);
  }

  public function testZeroOrMore3() {
    $parseA = new StringParser("a");
    $parser = $this->parserAlternative->zeroOrMore($parseA);
    $result = $parser->parse("aaabc");

    // expected
    $as = $this->listFactory->empty()->cons("a")->cons("a")->cons("a");
    $expected = $this->listFactory->pure(new Tuple($as, "bc"));

    $this->assertEquals($expected, $result);
  }

  public function testOneOrMore() {
    $parseA = new StringParser("a");
    $parser = $this->parserAlternative->oneOrMore($parseA);
    $result = $parser->parse("bcd");

    // Here, we assert that the parse *did* fail
    $this->assertTrue($result->isEmpty());
  }

  protected function assertAlternativesEqual($alt1, $alt2) {
    $input = "abc";
    $result1 = $alt1->parse($input);
    $result2 = $alt2->parse($input);

    $this->assertEquals($result1, $result2);
  }
}
