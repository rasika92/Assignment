<?php

class QueryWord {

  private $split_string;

  public function __construct($query_string) {
    // Replace the special character ? with 0.
    $replaced_string = str_replace('?', 0, $query_string);
    // Split the string and filter the array to remove null values.
    $split_string = array_filter(str_split($replaced_string));
    $this->split_string = $split_string;
  }

  /**
   * Function to get the split query word.
   */
  public function getSplitString() {
    return $this->split_string;
  }
}
