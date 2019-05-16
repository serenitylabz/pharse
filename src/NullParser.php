<?php

namespace Pharse;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class NullParser extends Parser {

  function parse($input) {
    $factory = new LinkedListFactory();
    //return $factory->pure(new Tuple('', $input));
    return $factory->empty();
  }
}
