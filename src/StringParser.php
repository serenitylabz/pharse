<?php

namespace Pharse;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class StringParser extends Parser {

  private $str;

  public function __construct($str) {
    $this->str = $str;
  }

  function parse($input) {
    $len = strlen($this->str);
    $factory = new LinkedListFactory();
    if (strlen($input) < $len) {
      return $factory->empty();
    } else {
      $sub = substr($input, 0, $len);
      if ($sub === $this->str) {
        $rest = substr($input, $len);
        $tuple = new Tuple($this->str, $rest);

        return $factory->pure($tuple);
      } else {
        return $factory->empty();
      }
    }
  }
}
