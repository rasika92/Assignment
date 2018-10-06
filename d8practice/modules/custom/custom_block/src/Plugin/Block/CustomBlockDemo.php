<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'Custom Block with Form fields' block.
 *
 * @Block(
 *   id = "custom_demo_block",
 *   admin_label = @Translation("Custom Demo Block"),
 *   category = @Translation("Custom Demo Block")
 * )
 */
class CustomBlockDemo extends BlockBase {

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();
    // Add a form field to the existing block configuration form.
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#required' => TRUE,
      '#default_value' => isset($config['btitle']) ? $config['btitle'] : '',
    );
    $form['image'] = array(
      '#title' => t('Image'),
      '#type' => 'managed_file',
      '#upload_location' => 'public://custom/',
      '#upload_validators' => array(
        'file_validate_extensions' => array('jpg jpeg png'),
      ),
      '#progress_message' => 'File is uploading, please wait...',
      '#theme' => 'image_widget',
      '#preview_image_style' => 'medium',
      '#required' => TRUE,
      '#default_value' => isset($config['bimage']) ? $config['bimage'] : '',
    );
    $form['description'] = array(
      '#type' => 'textfield',
      '#title' => t('Description'),
      '#required' => TRUE,
      '#default_value' => isset($config['bdescription']) ? $config['bdescription'] : '',
    );
    $form['ip_address'] = array(
      '#type' => 'textfield',
      '#title' => t('Restrict IP Address Range - From'),
      '#default_value' => isset($config['ip_address']) ? $config['ip_address'] : '',
    );
    $form['ip_address_upto'] = array(
      '#type' => 'textfield',
      '#title' => t('Restrict IP Address Range - To'),
      '#default_value' => isset($config['ip_address_upto']) ? $config['ip_address_upto'] : '',
    );
    return $form;
  }

  public function blockValidate($form, FormStateInterface $form_state) {
    // Get the IP address value.
    $ip_address = $form_state->getValue('ip_address');
    $ip_address_to = $form_state->getValue('ip_address_upto');
    // Validate the IP address if the field value exists.
    if (!empty($ip_address) && filter_var($ip_address, FILTER_VALIDATE_IP) == FALSE) {
      $form_state->setErrorByName('ip_address', t('Restrict IP Address Range - From field value is invalid.'));
    }
    elseif (!empty($ip_address_to) && filter_var($ip_address_to, FILTER_VALIDATE_IP) == FALSE) {
      $form_state->setErrorByName('ip_address_upto', t('Restrict IP Address Range - To field value is invalid.'));
    }
    // Check if both the IP range fields are set if either of the field has values.
    elseif(!empty($ip_address) && empty($ip_address_to)) {
      $form_state->setErrorByName('ip_address_upto', t('Restrict IP Address Range - To field is required.'));
    }
    elseif(empty($ip_address) && !empty($ip_address_to)) {
      $form_state->setErrorByName('ip_address', t('Restrict IP Address Range - From field is required.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('btitle', $form_state->getValue('title'));
    $this->setConfigurationValue('bimage', $form_state->getValue('image'));
    $this->setConfigurationValue('bdescription', $form_state->getValue('description'));
    $this->setConfigurationValue('ip_address', $form_state->getValue('ip_address'));
    $this->setConfigurationValue('ip_address_upto', $form_state->getValue('ip_address_upto'));
  }

  public function build() {
    // Disable caching for the block.
    $build['custom_block_demo'] = [
      '#cache' => [
        'max-age' => 0,
      ],
    ];
    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();
    // Get the client IP address.
    $client_ip_address = getenv('REMOTE_ADDR');
    // Convert the ip address to long for comparison.
    $long_client_ip_address = ip2long($client_ip_address);
    // Get the IP address set.
    $ip_address = isset($config['ip_address']) ? $config['ip_address'] : '';
    // Convert the ip address to long for comparison.
    $long_ip_address = ip2long($ip_address);
    // Get the IP address end range value set.
    $ip_address_to = isset($config['ip_address_upto']) ? $config['ip_address_upto'] : '';
    // Convert the ip address to long for comparison.
    $long_ip_address_to = ip2long($ip_address_to);
    // Allow the block to be visible only if the client IP falls within the IP address range set in the form or if no IP is set.
    if ((empty($ip_address) && empty($ip_address_to)) || !(($long_ip_address <= $long_client_ip_address) && ($long_client_ip_address <= $long_ip_address_to))) {
      // Get the title set.
      $title = isset($config['btitle']) ? $config['btitle'] : '';
      // Get the image set.
      $image = isset($config['bimage']) ? $config['bimage'] : '';
      // Get the description set.
      $description = isset($config['bdescription']) ? $config['bdescription'] : '';
      // If image is set, get the file id.
      if (!empty($image[0])) {
        // Load the file.
        $file = File::load($image[0]);
        // Create the thumbnail style image url to display.
        $image_url = ImageStyle::load('thumbnail')->buildUrl($file->getFileUri());
      }
      // Create the parameters array which are to be rendered.
      $build_data = array(
        'title' => $title,
        'image' => $image_url,
        'description' => $description
      );
      // Create final build array.
      $build['custom_block_demo'] = [
        '#theme' => 'custom_block_demo',
        '#data' => $build_data,
        '#attached' => ['library' => 'custom_block/custom_block.blocklayout'],
      ];
    }
    return $build;
  }

}
