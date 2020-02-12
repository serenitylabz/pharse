<?php

namespace Pharse;

use PhatCats\Typeclass\Alternative;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Tuple;

class ParserAlternative extends ParserApplicative implements Alternative {

  protected $factory;
  private $nullParse;

  public function __construct($listFactory = null) {
    $this->factory = is_null($listFactory) ? new LinkedListFactory() : $listFactory;
    $this->nullParser = new NullParser();
  }

  public function or($left, $right) {
    return new OrParser($left, $right);
  }

  function empty() {
    return $this->nullParser;
  }

  function zeroOrMore($parser) {
    return new ZeroOrMoreParser($parser);
  }

  function oneOrMore($parser) {
    return new OneOrMoreParser($parser);
  }
}

class OrParser extends Parser {

  private $firstParser;
  private $secondParser;

  public function __construct($firstParser, $secondParser) {
    $this->firstParser = $firstParser;
    $this->secondParser = $secondParser;
  }

  public function parse($input) {
    $firstParseResult = $this->firstParser->parse($input);

    return $firstParseResult->isEmpty() ? $this->secondParser->parse($input) : $firstParseResult;
  }
}

class ZeroOrMoreParser extends Parser {

  private $parser;
  private $factory;

  public function __construct($parser, $listFactory = null) {
    $this->parser = $parser;
    $this->factory = is_null($listFactory) ? new LinkedListFactory() : $listFactory;
  }

  public function parse($input) {
    // Try delegating to OneOrMoreParser.
    $firstResult = (new OneOrMoreParser($this->parser))->parse($input);

    if ($firstResult->isEmpty()) {
      // if OneOrMoreParser fails, ZeroOrMoreParser succeeds.
      $secondResult = $this->factory->pure(new Tuple($this->factory->empty(), $input));
    } else {
      $secondResult = $firstResult;
    }

    return $secondResult;
  }
}

class OneOrMoreParser extends Parser {

  private $parser;
  private $factory;

  public function __construct($parser, $listFactory = null) {
    $this->parser = $parser;
    $this->factory = is_null($listFactory) ? new LinkedListFactory() : $listFactory;
  }

  public function parse($input) {
    // unfolding function
    // In general, the unfolding function has type: b -> Maybe (a, b)
    // Here we specialize it to: String -> Maybe ((a, String), String)
    $fn = function($str) {
      return $this->parser->parse($str)->head()->map(function($tuple) {
        return new Tuple($tuple, $tuple->second());
      });
    };

    // The type of $results is LinkedList (a, String)
    // where a is the parsed thing and String is the unparsed input after the
    // given parse.
    $results = $this->factory->unfold($fn, $input);

    // If the list is empty, it's a failed parse
    if ($results->isEmpty()) {
      $result = $results;
    } else {
      // if it's not empty, we gather all the parsed things and then extract the
      // unparsed input from the last element.
      $values = $results->map(function($tuple) { return $tuple->first(); });
      $unparsedInput = $results->reverse()->head()->get()->second();

      $result = $this->factory->pure(new Tuple($values, $unparsedInput));
    }

    return $result;
  }
}
