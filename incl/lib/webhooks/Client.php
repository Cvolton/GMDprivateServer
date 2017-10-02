<?php

/**
 * Client generates the payload and sends the webhook payload to Discord
 */
class Client
{
  protected $url;
  protected $username;
  protected $avatar;
  protected $message;
  protected $embeds;
  protected $tts;
  public function __construct($url)
  {
    $this->url = $url;
  }
  public function tts($tts = false) {
    $this->tts = $tts;
    return $this;
  }
  public function username($username)
  {
    $this->username = $username;
    return $this;
  }
  public function avatar($new_avatar)
  {
    $this->avatar = $new_avatar;
    return $this;
  }
  public function message($new_message)
  {
    $this->message = $new_message;
    return $this;
  }
  public function embed($embed) {
    $this->embeds[] = $embed->toArray();
    return $this;
  }
  public function send()
  {
    $payload = json_encode(array(
      'username' => $this->username,
      'avatar_url' => $this->avatar,
      'content' => $this->message,
      'embeds' => $this->embeds,
      'tts' => $this->tts,
    ));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $result = curl_exec($ch);
    // Check for errors and display the error message
    if($errno = curl_errno($ch)) {
      $error_message = curl_strerror($errno);
      throw new \Exception("cURL error ({$errno}):\n {$error_message}");
    }
    $json_result = json_decode($result, true);
    if (($httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE)) != 204)
    {
      throw new \Exception($httpcode . ':' . $result);
    }
    curl_close($ch);
    return $this;
  }
}
 ?>