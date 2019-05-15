<?php

namespace Pharse\Test;

use Pharse\Parser;
use Pharse\ItemParser;
use Pharse\ParserApplicative;

class PhoneNumberParser extends Parser {

  public function parse($input) {
    $item = new ItemParser();
    $digit = $item->map("is_numeric");
    $parserApplicatvive = new ParserApplicative();
    $threeDigitApplicative = $parserApplicatvive->pure(function($a, $b, $c) { return [$a, $b, $c]; });
    $threeDigitParser = $threeDigitApplicative
                      ->apply($digit)
                      ->apply($digit)
                      ->apply($digit);

    return $threeDigitParser->parse($input);
  }
}
