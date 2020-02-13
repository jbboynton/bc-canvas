<?php

namespace BC\Canvas;

class ServicesPage {
  private $banner;
  private $intro_copy;
  private $cta;

  public function __construct() {
    $this->set_banner();
    $this->set_intro_copy();
    $this->set_cta();
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

  public function cta($size = 'large') {
    $cta = $this->cta;

    $cta['image'] = wp_get_attachment_image_url($cta['image'], $size);

    return $cta;
  }

  private function set_banner() {
    $this->banner = get_field('bc_canvas_page', 'options')['banner'];
  }

  private function set_intro_copy() {
    $this->intro_copy = get_field('bc_canvas_page', 'options')['intro_copy'];
  }

  private function set_cta() {
    $this->cta = get_field('bc_canvas_page', 'options')['cta'];
  }
}
