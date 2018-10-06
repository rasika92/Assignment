<?php

class QueryWord {

  private $split_string;

  public function __construct($query_string) {
    $replaced_string = str_replace('?', 0, $query_string);
    $split_string = array_filter(str_split($replaced_string));
    $this->split_string = $split_string;
  }

  public function getSplitString() {
    return $this->split_string;
  }
}
