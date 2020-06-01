<?php

namespace BC\Canvas;

use PostTypes\PostType;

class CanvasPostType {
  public const ID = 'canvas_service';
  public const PAGE_NAME = 'Canvas Page';
  public const PLURAL_NAME = 'Canvas';
  public const SINGULAR_NAME = 'Canvas Service';
  public const SLUG = 'canvas';

  private $cpt;
  private $icon = 'dashicons-admin-page';

  public function __construct() {
    $this->create_post_type();

    $this->set_options();
    $this->set_labels();

    $this->cpt->icon($this->icon);
    $this->cpt->register();
  }

  private function create_post_type() {
    $this->cpt = new PostType($this->names());
  }

  private function names() {
    return [
      'name' => self::ID,
      'singular' => self::SINGULAR_NAME,
      'plural' => self::PLURAL_NAME,
      'slug' => self::SLUG,
    ];
  }

  private function set_options() {
    $this->cpt->options([
      'public' => true,
      'show_in_nav_menus' => false,
      'show_in_menu_bar' => false,
      'menu_position' => 21.5,
      'supports' => ['revisions', 'page-attributes'],
      'has_archive' => self::SLUG,
      'rewrite' => ['slug' => self::SLUG, 'with_front' => false],
    ]);
  }

  private function set_labels() {
    $this->cpt->labels([
      'search_items' => self::PLURAL_NAME,
      'archives' => self::PLURAL_NAME,
      'menu_name' => self::PLURAL_NAME,
      'not_found' => 'No canvas services found',
      'not_found_in_trash' => 'No canvas services found in Trash',
      'search_items' => 'Search Canvas Services',
      'search_items' => self::PLURAL_NAME,
      'view_items' => 'View Canvas Services',
    ]);
  }
}
