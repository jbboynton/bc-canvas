<?php

namespace BC\Canvas;

use BC\Upholstery\Service as UpholsteryService;
use BC\Upholstery\UpholsteryPostType;

class Service {
  private $id;
  private $name;
  private $card_image;
  private $summary;
  private $banner;
  private $mini_image;
  private $intro_copy;
  private $upholstery_copy;
  private $upholstery_services;
  private $gallery_copy;
  private $gallery;
  private $cta;

  public static function find_by_name($name) {
    $query = new \WP_Query([
      'posts_per_page' => 1,
      'post_type' => CanvasPostType::ID,
      'name' => $name,
      'fields' => 'ids',
    ]);

    $id = $query->posts[0];

    return new Service($id);
  }

  public static function find_related_attachments($name) {
    $query = new \WP_Query([
      'nopaging' => true,
      'post_type' => 'attachment',
      'post_status' => 'inherit',
      'fields' => 'ids',
      'tax_query' => [
        [
          'taxonomy' => Services::TAXONOMY_ID,
          'field' => 'name',
          'terms' => $name,
        ],
      ],
    ]);

    return $query->posts ?? [];
  }

  private static function find_published($post_type, $post_ids) {
    $ids = [];

    foreach ($post_ids as $id) {
      $ids[] = intval($id);
    }

    $query = new \WP_Query([
      'nopaging' => true,
      'post_type' => $post_type,
      'post_status' => 'publish',
      'fields' => 'ids',
      'post__in' => $ids,
    ]);

    return $query->posts ?? [];
  }

  public function __construct($service_id = '') {
    $this->id = $service_id;
    $this->set_name();
    $this->set_card_image();
    $this->set_summary();
    $this->set_banner();
    $this->set_mini_image();
    $this->set_intro_copy();
    $this->set_upholstery_copy();
    $this->set_upholstery_services();
    $this->set_gallery_copy();
    $this->set_gallery();
    $this->set_cta();
  }

  public function id() {
    return $this->id;
  }

  public function name() {
    return $this->name;
  }

  public function slug() {
    return get_post_field('post_name', $this->id);
  }

  public function link() {
    return get_post_permalink($this->id);
  }

  public function term() {
    return get_term_by('name', $this->name, Services::TAXONOMY_ID);
  }

  public function card_image($size = 'large') {
    return wp_get_attachment_image_url($this->card_image, $size);
  }

  public function summary() {
    return $this->summary;
  }

  public function banner($size = 'full') {
    return wp_get_attachment_image_url($this->banner, $size);
  }

  public function mini_image($size = 'thumbnail') {
    return wp_get_attachment_image_url($this->mini_image, $size);
  }

  public function intro_copy() {
    return $this->intro_copy;
  }

  public function upholstery_copy() {
    return $this->upholstery_copy;
  }

  public function upholstery_services() {
    return array_map(function ($id) {
      return new UphosteryService($id);
    }, self::find_published(UpholsteryPostType::ID, $this->products));
  }

  public function cta($size = 'large') {
    $cta = $this->cta;

    $cta['image'] = wp_get_attachment_image_url($cta['image'], $size);

    return $cta;
  }

  private function set_name() {
    $default = 'Unnamed Canvas Service';

    $this->name = (get_field('bc_canvas_info', $this->id)['name'] ?: $default);
  }

  private function set_card_image() {
    $this->card_image = get_field('bc_canvas_images', $this->id)['card'];
  }

  private function set_banner() {
    $this->banner = get_field('bc_canvas_images', $this->id)['banner'];
  }

  private function set_mini_image() {
    $this->mini_image = get_field('bc_canvas_images', $this->id)['mini'];
  }

  private function set_intro_copy() {
    $this->intro_copy = get_field('bc_canvas_intro_copy', $this->id);
  }

  private function set_upholstery_copy() {
    $this->upholstery_copy = get_field('bc_canvas_upholstery_copy', $this->id);
  }

  private function set_upholstery_services() {
    $services = (array) get_field('ss_relation_canvas_upholstery', $this->id);

    sort($services);

    $this->upholstery_services = $services;
  }

  private function set_featured_links() {
    $this->featured_links = get_field('bc_canvas_featured', $this->id);
  }

  private function set_gallery_copy() {
    $this->gallery_copy = get_field('bc_canvas_gallery_copy', $this->id);
  }

  private function set_gallery() {
    $this->gallery = self::find_related_attachments($this->name);
  }

  private function set_cta() {
    $this->cta = get_field('bc_canvas_cta', $this->id);
  }
}
