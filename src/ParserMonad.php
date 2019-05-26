<?php

namespace Pharse;

use PhatCats\Typeclass\Monad;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserMonad extends ParserApplicative implements Monad {

  public function flatMap($parser, $f) {
    return new class($parser, $f) extends Parser {
      private $parser;
      private $f;

      public function __construct($parser, $f) {
        $this->parser = $parser;
        $this->f = $f;
      }

      function parse($input) {
        $firstParse = $this->parser->parse($input);
        $secondParse = $firstParse->flatMap(function($tuple) {
          $x = $tuple->first();
          $rest = $tuple->second();
          $nextParser = call_user_func($this->f, $x);

          return $nextParser->parse($rest);
        });

        return $secondParse;
      }
    };
  }

  public function then($parser1, $parser2) {
    return $this->flatMap($parser1, function ($ignore) use ($parser2) {
      return $parser2;
    });
  }

  function join($mma) {
    return $this->flatMap($mma, $identity);
  }
}
