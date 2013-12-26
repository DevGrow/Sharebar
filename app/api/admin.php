<?php

// This file should connect to the WP backend and manipulate items there
// AND generate whatever XML is needed when loading/saving configs

class SharebarAdmin {

  private static $sharebar;

  function __construct() {
    add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
    add_action( 'init', array( &$this, 'admin_scripts' ) );
  }

  function settings() {

  }

  function get() {

  }

  function set() {

  }

  function preserve_old() {

  }

  /**
   * Define the admin menu options for this plugin
   *
   * @uses add_action()
   * @uses add_options_page()
   */
  function admin_menu() {
    if(current_user_can('manage_options')) add_menu_page( "Sharebar", "Sharebar", 'administrator', PLUGIN_BASENAME, array('SharebarAdmin', 'admin'), PLUGIN_PATH . '/assets/images/icon.png' );
  }

  function admin_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-slider');
    wp_register_style('sharebar-css', PLUGIN_PATH . '/assets/stylesheets/application.css');
    wp_enqueue_style('sharebar-css');
  }

  public static function getInstance() {
    if (!self::$sharebar) {
      self::$sharebar = new self();
    }
    return self::$sharebar;
  }

  public static function admin() {
    wp_enqueue_script('sharebar-admin', PLUGIN_PATH . '/assets/javascripts/application.js');
    ?>
    <div id='sharebar-admin'>
      <div class="header">
        <a href="http://getsharebar.com/" class="logo">Sharebar</a>
      </div>
      <div class="primary-nav">
        <ul>
          <li><a href="#buttons">Buttons</a></li>
          <li><a href="#positioning">Positioning</a></li>
          <li><a href="#help">Help</a></li>
        </ul>
      </div>
      <div class="primary-content">
        <div class="sidebar">
          This is sidebar
        </div>
        <div class="content">

        </div>
      </div>
    </div>
    <?php
  }
}

?>