<?php

namespace Pharse;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

/**
 * A parser that parses the next n items from the input. If there are fewer than
 * n items available, it will not parse any items.
 */
class NItemParser extends Parser {

  private $numItems;
  private $factory;

  public function __construct($numItems) {
    if ($numItems < 1) {
      throw new \Exception("NItemParser expects a positive integer argument.");
    }

    $this->numItems = $numItems;
    $this->factory = new LinkedListFactory();
  }

  function parse($input) {
    if (strlen($input) < $this->numItems) {
      return $this->factory->empty();
    } else {
      $items = substr($input, 0, $this->numItems);
      $rest = substr($input, $this->numItems);
      $tuple = new Tuple($items, $rest);

      return $this->factory->pure($tuple);
    }
  }
}
