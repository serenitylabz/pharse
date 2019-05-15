<?php

namespace Pharse;

use PhatCats\Typeclass\Applicative;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;
use PhatCats\PartialFunction;

class ParserApplicative extends ParserFunctor implements Applicative {

  public function pure($v) {
    return new class($v) extends Parser {
      private $v;

      public function __construct($v) {
        $this->v = $v;
      }

      function parse($input) {
        $listFactory = new LinkedListFactory();
        return $listFactory->pure(new Tuple($this->v, $input));
      }
    };
  }

  public function apply($ff, $fa = null) {
    // TODO we'll ignore the case where $fa == null, for now.
    return new class($ff, $fa) extends Parser {
      private $ff;
      private $fa;

      public function __construct($ff, $fa) {
        $this->ff = $ff;
        $this->fa = $fa;
      }

      function parse($input) {
        $firstParse = $this->ff->parse($input);
        $secondParse = $firstParse->flatMap(function($tuple) {
          $f = $tuple->first();
          $rest = $tuple->second();

          // Make sure $f is a PartialFunction
          $pf = $f instanceof PartialFunction ?
              $f :
              new PartialFunction($f);

          $secondParse = $this->fa->map($pf)->parse($rest);

          return $secondParse;
        });

        return $secondParse;
      }
    };
  }
}
