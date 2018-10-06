<?php

namespace Drupal\custom_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class HackNumberForm extends FormBase {

  public function getFormId() {
    return 'hack_number_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['string1'] = array(
      '#type' => 'textfield',
      '#title' => t('String 1'),
      '#required' => TRUE,
    );
    $form['string2'] = array(
      '#type' => 'textfield',
      '#title' => t('String 2'),
      '#required' => TRUE,
    );
    $form['character'] = array(
      '#type' => 'radios',
      '#required' => TRUE,
      '#title' => $this->t('Character'),
      '#options' => array(
        'yes' => $this->t('Y'),
        'no' => $this->t('N')),
    );
    $form['initial_position'] = array(
      '#type' => 'textfield',
      '#attributes' => array(
        ' type' => 'number',
      ),
      '#title' => t('Integer Value'),
      '#required' => TRUE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $string1 = $form_state->getValue('string1');
    $string2 = $form_state->getValue('string2');
    // The length of string 2 should not be greater than that of string 1.
    if (strlen($string2) > strlen($string1)) {
      $form_state->setErrorByName('string2', t('String 2 length cannot be greater than that of String 1.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $string1 = $form_state->getValue('string1');
    $string2 = $form_state->getValue('string2');
    $character = $form_state->getValue('character');
    $initial_position = $form_state->getValue('initial_position');
    switch ($character) {
      case "yes":
        $string_position = $this->c_value_yes($string1, $string2, $initial_position);
        drupal_set_message($string_position);
        break;
      case "no":
        $string_position = $this->c_value_no($string1, $string2, $initial_position);
        drupal_set_message($string_position);
        break;
    }
  }

  public function c_value_yes($string1, $string2, $initial_position) {
    $string_position = $this->string_occurence($string1, $string2, $initial_position);
    return $string_position;
  }

  public function c_value_no($string1, $string2, $initial_position) {
    return stripos($string1, $string2, $initial_position);
  }

  public function string_occurence($string1, $string2, $initial_position) {
    $pattern = "/(?:^|[^a-zA-Z])" . preg_quote($string2, '/') . "(?:$|[^a-zA-Z])/i";
    $exists = preg_match($pattern, $string1, $matches, PREG_OFFSET_CAPTURE, $initial_position);
    if ($exists) {
      $string_position = $matches[0][1] + 1;
    }
    else {
      $string_position = 'No Worries';
    }
    return $string_position;
  }

}
