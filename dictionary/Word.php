<?php

class Word {

  private $split_word;

  public function __construct($word) {
    $this->split_word = str_split($word);
  }

  public function isMatch($query) {
    $query_split_string = $query->getSplitString();
    $result = array_intersect_assoc($this->split_word, $query_split_string);
    if (sizeof($result) == sizeof($query_split_string)) {
      return true;
    }
    return false;
  }

}
