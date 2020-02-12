<?php

namespace Pharse;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class NullParser extends Parser {

  private static $instance;

  private function __construct() {}

  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new NullParser();
    }
    return self::$instance;
  }

  function parse($input) {
    $factory = new LinkedListFactory();
    //return $factory->pure(new Tuple('', $input));
    return $factory->empty();
  }
}
