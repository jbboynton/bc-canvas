<?php

namespace BC\Canvas;

class ServicesPage {
  private $banner;
  private $intro_copy;
  private $featured_copy;
  private $featured_services;

  public function __construct() {
    $this->set_banner();
    $this->set_intro_copy();
    $this->set_featured();
  }

  public function name() {
    return get_post_type_object(CanvasPostType::ID)->labels->name;
  }

  public function banner($size = 'full') {
    return wp_get_attachment_image_url($this->banner, $size);
  }

  public function link() {
    return get_post_type_archive_link(CanvasPostType::ID);
  }

  public function intro_copy() {
    return $this->intro_copy;
  }

  public function featured_copy() {
    return $this->featured_copy;
  }

  public function featured_services() {
    return array_map(function ($id) {
      return new Service($id);
    }, Service::find_published(CanvasPostType::ID, $this->featured_services));
  }

  private function set_banner() {
    $this->banner = get_field('bc_canvas_page_images', 'options')['banner'];
  }

  private function set_intro_copy() {
    $this->intro_copy = get_field('bc_canvas_page_intro_copy', 'options');
  }

  private function set_featured() {
    $featured = get_field('bc_canvas_page_featured', 'options');

    $this->featured_copy = [
      'heading' => $featured['heading'],
      'subheading' => $featured['subheading'],
    ];

    $this->featured_services = $featured['services'];
  }
}
