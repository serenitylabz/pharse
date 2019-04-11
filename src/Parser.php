<?php

namespace Pharse;

//use PhatCats\Typeclass\Monad;

interface Parser {

  /**
   * "A Parser for Things
   * is a function from Strings
   * to Lists of Pairs
   * of Things and Strings!"
   *
   * From http://www.willamette.edu/~fruehr/haskell/seuss.html
   *
   * This method takes a string as input and returns a PhatCats\LinkedList where
   * each element is a PhatCats\Tuple.  The first element of the tuple is a
   * value of whatever type the parser parses; it would typically be a custom
   * type of your choosing.  The second element of the tuple is a string that is
   * the unconsumed input.
   */
  function parse($input);
}
