<?php

// This file should inject the sharebar codes into posts/pages

class SharebarPosts {

  private static $sharebar;

  function __construct() {
    add_filter("the_content", array(&$this, "add_to_posts"));
    add_action("init", array(&$this, "register_scripts"));
  }

  function add_to_posts($the_content) {
    return "<div id='sharebar-horizontal'></div><div id='sharebar-vertical'></div>".$the_content;
  }

  function register_scripts() {
    wp_enqueue_script("sharebar_js", PLUGIN_PATH . "/assets/javascripts/sharebar.js", array(), false, true);
    wp_enqueue_style("sharebar_css", PLUGIN_PATH . "/assets/stylesheets/sharebar.css");
  }

  public static function getInstance() {
    if (!self::$sharebar) {
      self::$sharebar = new self();
    }
    return self::$sharebar;
  }

}

?>