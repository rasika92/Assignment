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
    
    $pattern = "/(?:^|[^a-zA-Z])" . preg_quote($this->string2, '/') . "(?:$|[^a-zA-Z])/i";
    $exists = preg_match($pattern, $this->string1, $matches, PREG_OFFSET_CAPTURE, $this->initial_pos);
    if ($exists) {
      $string_position = $matches[0][1] + 1;
    }
    else {
      $string_position = 'No Worries';
    }
    return $string_position;
  }

  public function c_value_no() {
    $string_position = stripos($this->string1, $this->string2, $this->initial_pos);
    if ($string_position) {
      return $string_position;
    }
    else {
      return 'No Worries';
    }
  }

}
