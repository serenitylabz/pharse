<?php

namespace Pharse;

use PhatCats\Typeclass\Alternative;
use PhatCats\LinkedList\LinkedListFactory;

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
