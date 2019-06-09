<?php

namespace Pharse\Test;

require_once __DIR__ . "/../vendor/serenitylabs/phatcats/test/Typeclass/Alternative/AlternativeTest.php";
use PhatCats\Test\Typeclass\Alternative\AlternativeTest;
use Pharse\ParserAlternative;

class ParserAlternativeTest extends AlternativeTest {

  private $parserAlternative;

  public function setUp() {
    $this->parserAlternative = new ParserAlternative();
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

  protected function assertAlternativesEqual($alt1, $alt2) {
    $input = "abc";
    $result1 = $alt1->parse($input);
    $result2 = $alt2->parse($input);

    $this->assertEquals($result1, $result2);
  }
}
