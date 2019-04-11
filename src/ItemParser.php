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

  // function map(callable $f) {
  //   return new class($this, $f) extends Parser {
  //     private $parser;
  //     private $f;

  //     public function __construct($parser, $f) {
  //       $this->parser = $parser;
  //       $this->f = $f;
  //     }

  //     public function parse($input) {
  //       $parseResult = $this->parser->parse($input);
  //       return  $parseResult->map(function($tuple) {
  //         $mappedResult = 
  //       });
  //       // if ($parseResult->isEmpty()) {
          
  //       // } else {
  //       // }
  //     }
  //   };
  // }
}
