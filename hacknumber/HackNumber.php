<?php

class HackNumber {

  private $string1;
  private $string2;
  private $initial_position;

  function __construct($string1, $string2, $initial_position) {
    $this->string1 = $string1;
    $this->string2 = $string2;
    $this->initial_pos = $initial_position;
  }

  public function c_value_yes() {
    // Create a pattern which will check if the word is to the start end or a standalone word in a string.
    $pattern = "/(?:(?<=\s)|(?<=^))" . preg_quote($this->string2, '/') . "(?:(?=\s)|(?=$))/i";
    // Match the pattern to check if the word exists in the string.
    $exists = preg_match($pattern, $this->string1, $matches, PREG_OFFSET_CAPTURE, $this->initial_pos);
    // If the word exists, return its first occurence.
    if ($exists) {
      $string_position = $matches[0][1];
    }
    else {
      $string_position = 'No Worries';
    }
    return $string_position;
  }

  public function c_value_no() {
    // Check if the word exists in the string, need not be standalone word.
    $string_position = stripos($this->string1, $this->string2, $this->initial_pos);
    if (is_int($string_position)) {
      return $string_position;
    }
    else {
      return 'No Worries';
    }
  }

}
