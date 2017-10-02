<?php

/**
 * Embed is an embed object to be included in a webhook message
 */
class Embed
{
  protected $title;
  protected $type = "rich";
  protected $description;
  protected $url;
  protected $timestamp;
  protected $color;
  protected $footer;
  protected $image;
  protected $thumbnail;
  protected $video;
  protected $provider;
  protected $author;
  protected $fields;
  public function title($title, $url = '') {
    $this->title = $title;
    $this->url = $url;
    return $this;
  }
  public function description($description) {
    $this->description = $description;
    return $this;
  }
  public function timestamp($timestamp) {
    $this->timestamp = $timestamp;
    return $this;
  }
  public function color($color) {
    $this->color = $color;
    return $this;
  }
    public function url($url) {
        $this->url = $url;
        return $this;
    }
  public function footer($text, $icon_url = '')
  {
    $this->footer = [
      'text' => $text,
      'icon_url' => $icon_url,
    ];
    return $this;
  }
  public function image($url)
  {
    $this->image = [
      'url' => $url,
    ];
    return $this;
  }
  public function thumbnail($url)
  {
    $this->thumbnail = [
      'url' => $url,
    ];
    return $this;
  }
  public function author($name, $url = '', $icon_url = '')
  {
    $this->author = [
      'name' => $name,
      'url' => $url,
      'icon_url' => $icon_url,
    ];
    return $this;
  }
  public function field($name, $value, $inline = false)
  {
    $this->fields[] = [
      'name' => $name,
      'value' => $value,
      'inline' => boolval($inline),
    ];
    return $this;
  }
  public function toArray()
  {
    return [
      'title' => $this->title,
      'type' => $this->type,
      'description' => $this->description,
      'url' => $this->url,
      'color' => $this->color,
      'footer' => $this->footer,
      'image' => $this->image,
      'thumbnail' => $this->thumbnail,
      'author' => $this->author,
      'fields' => $this->fields,
    ];
  }
}