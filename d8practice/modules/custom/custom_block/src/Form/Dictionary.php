<?php

namespace Drupal\custom_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class Dictionary extends FormBase {

  public function getFormId() {
    return 'dictionary_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['no_of_words'] = array(
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number',
      ),
      '#title' => t('Integer Value'),
      '#required' => TRUE,
    );
    $form['word_length'] = array(
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number',
      ),
      '#title' => t('Word Length'),
      '#required' => TRUE,
    );
    $form['word1'] = array(
      '#type' => 'textfield',
      '#title' => t('Word 1'),
      '#required' => TRUE,
    );
    $form['word2'] = array(
      '#type' => 'textfield',
      '#title' => t('Word 2'),
      '#required' => TRUE,
    );
    $form['no_of_queries'] = array(
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number',
      ),
      '#title' => t('Number of queries'),
      '#required' => TRUE,
    );
    $form['query1'] = array(
      '#type' => 'textfield',
      '#title' => t('Query Word 1'),
      '#required' => TRUE,
    );
    $form['query2'] = array(
      '#type' => 'textfield',
      '#title' => t('Query Word 1'),
      '#required' => TRUE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $no_of_words_in_dictionary = $form_state->getValue('no_of_words');
    $word_length = $form_state->getValue('word_length');
    $no_of_queries = $form_state->getValue('no_of_queries');
    $word1 = $form_state->getValue('word1');
    $word2 = $form_state->getValue('word2');
    $query1 = $form_state->getValue('query1');
    $query2 = $form_state->getValue('query2');
    $words = [$word1, $word2];
    $queries = [$query1, $query2];
    foreach ($words as $wkey => $word) {
      $warray[$word] = str_split($word);
    }
    foreach ($queries as $qkey => $query) {
      $replaced_string = str_replace('?', 0, $query);
      $split_string = array_filter(str_split($replaced_string));
      $qarray[$query] = $split_string;
    }
    foreach ($qarray as $qarraykey => $eachq) {
      $matches[$qarraykey] = [];
      foreach ($warray as $warraykey => $eachw) {
        $result = array_intersect_assoc($eachw, $eachq);
        if (sizeof($result) == sizeof($eachq)) {
          $matches[$qarraykey][] = $warraykey;
        }
      }
    }
    foreach ($matches as $mkey => $match) {
      drupal_set_message('Number of words for query "' . $mkey . '" is - ' . sizeof($match));
    }
  }

}
