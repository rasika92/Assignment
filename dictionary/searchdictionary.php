<?php

require 'Word.php';
require 'QueryWord.php';

// Get the entered form values.
$no_of_words_in_dictionary = $_POST['no_of_words'];
$word_length = $_POST['word_length'];
$no_of_queries = $_POST['no_of_queries'];
for($i=1;$i<=$no_of_words_in_dictionary;$i++) {
  // Word length should match the length given in input.
  if (strlen($_POST["word$i"]) < $word_length || strlen($_POST["word$i"]) > $word_length) {
    echo 'The word length for ' .$_POST["word$i"] . ' does not match the length given in input';exit;
  }
  $words[] = $_POST["word$i"];
}
for($j=1;$j<=$no_of_queries;$j++) {
  // Query length should match the length given in input.
  if (strlen($_POST["query$j"]) < $word_length || strlen($_POST["query$j"]) > $word_length) {
    echo 'The query length for ' .$_POST["query$j"] . ' does not match the length given in input';exit;
  }
  $queries[] = $_POST["query$j"];
}

foreach ($words as $wkey => $word) {
  // Create word object to set the value.
  $warray[$word] = new Word($word);
}
foreach ($queries as $qkey => $query) {
  // Create query object to set the value.
  $qarray[$query] = new QueryWord($query);
}

foreach ($qarray as $qarraykey => $eachq) {
  $matches[$qarraykey] = [];
  foreach ($warray as $warraykey => $eachw) {
    // For a given query check if the word matches.
    $result = $eachw->isMatch($eachq);
    if ($result) {
      // If the word matches a query, create output array.
      $matches[$qarraykey][] = $warraykey;
    }
  }
}

foreach ($matches as $mkey => $match) {
  // For every output print the occurences of words matching a query.
  print'<pre>';print_r('Number of words for query "' . $mkey . '" is - ' . sizeof($match));'</pre>';
}
