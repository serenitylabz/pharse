<?php

namespace Pharse\Test;

use Pharse\Parser;
use Pharse\ItemParser;
use Pharse\NullParser;
use Pharse\ParserApplicative;
use Pharse\ParserMonad;
use Phatcats\Tuple;

class PhoneNumberParser extends Parser {

  public function parse($input) {

    // An Applicative instance is needed.
    $parserApplicatvive = new ParserApplicative();

    // Create a digit parser
    $item = new ItemParser();
    $digit = $item->flatMap(function ($c) use ($parserApplicatvive) {
      return is_numeric($c) ? $parserApplicatvive->pure($c) : new NullParser();
    });

    // Create a 3-digit parser
    $threeDigitApplicative = $parserApplicatvive->pure(function($a, $b, $c) { return [$a, $b, $c]; });
    $threeDigitParser = $threeDigitApplicative
                      ->apply($digit)
                      ->apply($digit)
                      ->apply($digit);

    // Create a 4-digit parser
    $fourDigitApplicative = $parserApplicatvive->pure(function($a, $b, $c, $d) { return [$a, $b, $c, $d]; });
    $fourDigitParser = $fourDigitApplicative
                     ->apply($digit)
                     ->apply($digit)
                     ->apply($digit)
                     ->apply($digit);

    // Sequence the two parsers
    $parserMonad = new ParserMonad();
    $phoneNumberParser = $parserMonad->flatMap($threeDigitParser, function ($threeDigitArray) use ($fourDigitParser) {
      return new class($threeDigitArray, $fourDigitParser) extends Parser {
        private $threeDigitArray;
        private $fourDigitParser;

        public function __construct($tda, $fdp) {
          $this->threeDigitArray = $tda;
          $this->fourDigitParser = $fdp;
        }

        public function parse($input) {
          $parseResult = $this->fourDigitParser->parse($input);

          return $parseResult->map(function ($tuple) {
            $fourDigitArray = $tuple->first();
            $rest = $tuple->second();
            $phoneNumberAsArray = [$this->threeDigitArray, $fourDigitArray];

            return new Tuple($phoneNumberAsArray, $rest);
          });
        }
      };
    });

    return $phoneNumberParser->parse($input);
  }
}
