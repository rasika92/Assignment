<?php

class Word {

  private $split_word;

  public function __construct($word) {
    $this->split_word = str_split($word);
  }

  /**
   * Check if word matches a given query.
   */
  public function isMatch($query) {
    // Get the split query string.
    $query_split_string = $query->getSplitString();
    // Check the matching key value pairs from both the arrays.
    $result = array_intersect_assoc($this->split_word, $query_split_string);
    // If the result and query array size matches, there is a match found.
    if (sizeof($result) == sizeof($query_split_string)) {
      return true;
    }
    return false;
  }

}
