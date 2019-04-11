<?php

namespace Pharse;

use PhatCats\Typeclass\Functor;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserFunctor implements Functor {

  function map($parser, callable $f) {
    return new class($parser, $f) implements Parser {
      function __construct($parser, callable $f) {
        $this->parser = $parser;
        $this->f = $f;
        $this->listFactory = new LinkedListFactory();
      }

      function parse($input) {
        $l = $this->parser->parse($input);
        return $l->map(function ($tuple) {
          $first = $tuple->first();
          $second = $tuple->second();
          $newFirst = call_user_func($this->f, $first);

          return new Tuple($newFirst, $second);
        });
      }
    };
  }
}
