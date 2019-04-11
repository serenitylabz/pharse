<?php

namespace Pharse;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ItemParser implements Parser {

  function parse($input) {
    if ($input === '') {
      return (new LinkedListFactory())->empty();
    } else {
      $chr = substr($input, 0, 1);
      $rest = substr($input, 1);
      $factory = new LinkedListFactory();
      $tuple = new Tuple($chr, $rest);

      return $factory->pure($tuple);
    }
  }

  function map(callable $f) {
    return (new ParserFunctor())->map($this, $f);
  }
}
