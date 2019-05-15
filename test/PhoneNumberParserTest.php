<?php

namespace Pharse\Test;

use PHPUnit\Framework\TestCase;
use Phatcats\LinkedList\LinkedListFactory;
use Phatcats\Tuple;

class PhoneNumberParserTest extends TestCase {

  public function testPhoneNumberParser() {

    $phoneNumberParser = new PhoneNumberParser();

    $result = $phoneNumberParser->parse("8675309");
    $listFactory = new LinkedListFactory();
    $expectedResult = $listFactory->pure(new Tuple([8, 6, 7], "5309"));

    $this->assertEquals($expectedResult, $result);
  }
}
