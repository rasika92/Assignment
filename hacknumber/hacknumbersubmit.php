<?php

 require 'HackNumber.php';

// Get the entered form values.
$string1 = $_POST['string1'];
$string2 = $_POST['string2'];
$character = $_POST['character'];
$initial_position = $_POST['initial_position'];

// Create a class object and pass the parameters to the contructor.
$hack_no_obj = new HackNumber($string1, $string2, $initial_position);

// Switch case to execute the logic depending on the character field user input.
switch ($character) {
  case "yes":
    $string_position = $hack_no_obj->c_value_yes();
    break;
  case "no":
    $string_position = $hack_no_obj->c_value_no();
    break;
}

print'<pre>';print_r($string_position);print'</pre>';
