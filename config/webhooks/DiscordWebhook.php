<?php

class DiscordWebhook {

  # DiscordWebhook-PHP
  # github.com/renzbobz
  # 2/9/23

  public $webhook = null;
  public $parseJSON = true;
  public $curlOpts = [];
  
  //? Query string params
  public $wait = false;
  public $threadId = null;
  
  //? Message props
  public $content = null;
  public $username = null;
  public $avatarUrl = null;
  public $tts = false;
  public $embeds = [];
  public $allowedMentions = [];
  public $attachments = [];
  public $flags = null;
  public $threadName = null;
  
  public $files = [];
  public $embed = [];
  public $messageId = null;
  private $_offsetIndex = 0;

  public function __construct($webhook, $opts=[]) { 
    $opts = $webhook && !$opts ? $webhook : [ "webhook" => $webhook, ...$opts ];
    $this->_setOpts($opts); 
  }
  public function toJSON() { return $this->_getData(); }

  //! Helpers
  private function _setOpts($opts) {
    if (is_string($opts)) {
      $this->webhook = $opts;
    } else if (is_array($opts)) {
      foreach ($opts as $key => $val) {
        $this->{$key} = $val;
      }
    }
  }

  private function _resolveColor($clr) {
    if (is_string($clr)) {
      if ($clr == 'random') return rand(0x000000, 0xFFFFFF);
      if ($clr[0] == '#') $clr = substr($clr, 1);
      if (preg_match('/,/', $clr)) $clr = sprintf('%02x%02x%02x', ...explode(',', $clr));
      $clr = hexdec($clr);
    }
    return $clr;
  }

  private function _setPropArrayValue($prop, $firstArg, $structuredVal) {
    if (is_array($firstArg)) {
      $this->{$prop} = $firstArg;
    } else {
      $this->{$prop} = $structuredVal;
    }
  }

  private function _silentJSONParse($str) {
    $json = json_decode($str, true);
    if (json_last_error() != JSON_ERROR_NONE) {
      return $str;
    }
    return $json;
  }

  private function _arrayAdderHandler($name, $values) {
    foreach ($values as $value) {
      if (!$value) continue;
      // indexed array
      if (isset($value[0])) {
        $this->{$name}(...$value);
      // associative array
      } else {
        $this->{$name}($value);
      }
    }
  }

  private function _getData() {
    $embed = $this->embed;
    $embeds = $this->embeds;
    if ($embed || $embeds) {
      // sort embeds by key first before adding the main embed so it doesn't change the order
      ksort($embeds);
      if ($embed) array_splice($embeds, $this->_offsetIndex, 0, [$embed]);
    }
    $data = [
      "content" => $this->content,
      "username" => $this->username,
      "avatar_url" => $this->avatarUrl,
      "tts" => $this->tts,
      "flags" => $this->flags,
      "embeds" => $embeds,
      "attachments" => $this->attachments,
      "thread_name" => $this->threadName,
    ];
    if ($this->allowedMentions) $data["allowed_mentions"] = $this->allowedMentions;
    return json_encode($data);
  }

  private function _getFormData() {
    $files = [];
    foreach ($this->files as $id => $file) {
      $snowflake = $this->_getFileSnowflakeById($id);
      $files["files[$snowflake]"] = curl_file_create($file["path"], $file["type"], $file["name"]);
    }
    $data = [
      "payload_json" => $this->_getData(),
    ] + $files;
    return $data;
  }

  private function _setEmbed($key, $value, $append=false) {
    return $append ? $this->embed[$key][] = $value : $this->embed[$key] = $value;
  }
  private function _getEmbed($key) {
    return $key ? $this->embed[$key] : $this->embed;
  }
  private function _setEmbedArrayValue($key, $firstArg, $structuredVal) {
    return $this->_setEmbed($key, is_array($firstArg) ? $firstArg : $structuredVal);
  }

  private function _getFileSnowflakeById($id) {
    if (isset($this->files[$id])) {
      return $this->files[$id]["snowflake"];
    } else {
      throw new Exception("No file found with the id of ($id). Make sure you add the file first with the id of ($id).");
    }
  }

  private function _getWebhookMsgUrl($messageId=null) {
    $messageId = $messageId ?? $this->_getMessageId();
    $webhook = $this->_buildWebhookQuery($this->_getWebhook().'\/messages\/'.$messageId);
    return $webhook;
  }

  private function _getMessageId() {
    $messageId = $this->messageId;
    if (!$messageId) throw new Exception("Message Id is Required.");
    return $messageId;
  }

  private function _getPostCurlOpts() {
    if ($this->files) {
      $contentType = 'multipart/form-data';
      $data = $this->_getFormData();
    } else {
      $contentType = "application/json";
      $data = $this->_getData();
    }
    return [
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => [
        'Content-type: '.$contentType
      ]
    ];
  }

  private function _getWebhook() {
    $webhook = $this->webhook;
    if (!$webhook) throw new Exception("Webhook is Required.");
    return $webhook;
  }

  private function _buildWebhookQuery($webhook) {
    $query = [];
    if ($this->wait) $query['wait'] = true;
    if ($this->threadId) $query['thread_id'] = $this->threadId;
    if ($query) $webhook .= '?' . http_build_query($query);
    return $webhook;
  }

  private function _buildCurlOpts($opts=[]) {
    $defaultOpts = [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
    ];
    return $defaultOpts + $opts + $this->curlOpts;
  }

  private function _curlResHandler($ch, $body) {
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $success = $code >= 200 && $code < 299;
    $curlErr = curl_error($ch);
    
    $res = [
      'success' => $success,
      'code' => $code,
      'curl_error' => $curlErr,
    ];

    $parsedBody = $this->_silentJSONParse($body);

    $res['body'] = $this->parseJSON ? $parsedBody : $body;

    if ($success && isset($parsedBody['id'])) $this->messageId = $parsedBody['id'];
    
    return (object) $res;
  }

  private function _execCurl($url, $opts=[]) {
    $ch = curl_init($url);

    curl_setopt_array($ch, $opts);
    $body = curl_exec($ch);
    curl_close($ch);

    return $this->_curlResHandler($ch, $body);
  }

  public function setWebhook($webhook) {
    $this->webhook = $webhook;
    return $this;
  }

  # Bot profile
  public function setUsername($username) {
    $this->username = $username;
    return $this;
  }
  public function setAvatar($avatarUrl) {
    $this->avatarUrl = $avatarUrl;
    return $this;
  }

  # Query string params
  public function setThreadId($id) {
    $this->threadId = $id;
    return $this;
  }
  public function waitMessage($wait) {
    $this->wait = $wait;
    return $this;
  }

  # Clone
  public function newMessage($message=null) {
    $cloned = clone $this;
    if ($message) $cloned->setContent($message);
    return $cloned;
  }
  public function newThread($name=null) {
    $cloned = $this->newMessage();
    $cloned->threadName = $name;
    return $cloned;
  }

  # Msg content
  public function setContent($content) {
    $this->content = $content;
    return $this;
  }
  public function prependContent($content) {
    $this->content = $content . $this->content;
    return $this;
  }
  public function appendContent($content) {
    $this->content .= $content;
    return $this;
  }

  # Msg content text to speech
  public function setTts($tts=true) {
    $this->tts = $tts;
    return $this;
  }

  # Embed title
  public function setTitle($title, $url=null) {
    $this->_setEmbed("title", $title);
    if ($url) $this->setUrl($url);
    return $this;
  }
  public function prependTitle($title) {
    $this->_setEmbed("title", $title . $this->_getEmbed("title"));
    return $this;
  }
  public function appendTitle($title) {
    $this->_setEmbed("title", $this->_getEmbed("title") . $title);
    return $this;
  }

  # Embed url
  public function setUrl($url) {
    $this->_setEmbed("url", $url);
    return $this;
  }

  # Embed description
  public function setDescription($desc) {
    $this->_setEmbed("description", $desc);
    return $this;
  }
  public function prependDescription($desc) {
    $this->_setEmbed("description", $desc . $this->_getEmbed("description"));
    return $this;
  }
  public function appendDescription($desc) {
    $this->_setEmbed("description", $this->_getEmbed("description") . $desc);
    return $this;
  }

  # Embed color
  public function setColor($clr) {
    $this->_setEmbed("color", $this->_resolveColor($clr));
    return $this;
  }
  public function setRandomColor() {
    $this->_setEmbed("color", $this->_resolveColor("random"));
    return $this;
  }

  # Embed timestamp
  public function setTimestamp($ts=null) {
    if (!$ts) $ts = date('c');
    $this->_setEmbed("timestamp", $ts);
    return $this;
  }

  # Embed author
  public function setAuthor($name, $url=null, $iconUrl=null, $proxyIconUrl=null) {
    $this->_setEmbedArrayValue("author", $name, [
      "name" => $name,
      "url" => $url,
      "icon_url" => $iconUrl,
      "proxy_icon_url" => $proxyIconUrl,
    ]);
    return $this;
  }

  # Embed thumbnail
  public function setThumbnail($url, $proxyUrl=null, $height=null, $width=null) {
    $this->_setEmbedArrayValue("thumbnail", $url, [
      "url" => $url,
      "proxy_url" => $proxyUrl,
      "height" => $height,
      "width" => $width,
    ]);
    return $this;
  }

  # Embed image
  public function setImage($url, $proxyUrl=null, $height=null, $width=null) {
    $this->_setEmbedArrayValue("image", $url, [
      "url" => $url,
      "proxy_url" => $proxyUrl,
      "height" => $height,
      "width" => $width,
    ]);
    return $this;
  }

  # Embed footer
  public function setFooter($text, $iconUrl=null, $proxyIconUrl=null) {
    $this->_setEmbedArrayValue("footer", $text, [
      "text" => $text,
      "icon_url" => $iconUrl,
      "proxy_icon_url" => $proxyIconUrl
    ]);
    return $this;
  }

  # Embed fields
  public function addField($name, $value=null, $inline=false) {
    $this->embed["fields"][] = is_array($name) ? $name : [
      "name" => $name,
      "value" => $value,
      "inline" => $inline
    ];
    return $this;
  }
  public function addFields(...$fields) {
    $this->_arrayAdderHandler("addField", $fields);
    return $this;
  }

  # Message files
  public function addFile($id, $path=null, $name=null, $type=null) {
    $snowflake = count($this->files);
    if (is_array($id)) {
      $this->files[$id["id"]] = [ 
        ...$id, 
        "snowflake" => $snowflake,
      ];
    } else {
      $this->files[$id] = [
        "path" => $path,
        "name" => $name,
        "type" => $type,
        "snowflake" => $snowflake,
      ];
    }
    return $this;
  }
  public function addFiles(...$files) {
    $this->_arrayAdderHandler("addFile", $files);
    return $this;
  }

  # Message attachments
  public function addAttachment($id, $filename=null) {
    if (is_array($id)) {
      $attachment = $id;
      // if not is set size, then it's not direct arg data
      if (!isset($attachment["size"])) $attachment["id"] = $this->_getFileSnowflakeById($attachment["id"]);
    } else {
      $snowflake = $this->_getFileSnowflakeById($id);
      $attachment = [
        "id" => $snowflake,
        "filename" => $filename,
      ];
    }
    $this->attachments[] = $attachment;
    return $this;
  }
  public function addAttachments(...$attachments) {
    $this->_arrayAdderHandler("addAttachment", $attachments);
    return $this;
  }

  # Message flag
  public function setFlag($flag) {
    $this->flags = $flag;
    return $this;
  }

  # Message allowed mentions
  public function setAllowedMentions($data) {
    $this->allowedMentions = $data;
    return $this;
  }

  # Add Embed. Chain multiple embed
  // $embed = DiscordWebhook | DiscordEmbed
  public function addEmbed($embedClass, $indx=null, $replace=false) {
    // DiscordWebhook->embed | DiscordEmbed->toArray()
    $embed = property_exists($embedClass, "embed") ? $embedClass->embed : $embedClass->toArray();
    if (is_null($indx)) {
      // if embeds are still empty then assign this first embed to index 1, in respect to main embed,
      if (!$this->embeds && $this->embed) return $this->addEmbed($embedClass, 1);
      // otherwise append embed
      $this->embeds[] = $embed;
    } else {
      // if embed wants to be the first, change main embed offset to 1 to move it
      if ($indx == 0) $this->_offsetIndex = 1;
      // if indx is already taken and not replace, insert and move
      if (isset($this->embeds[$indx])) {
        array_splice($this->embeds, $indx-1, $replace ? 1 : 0, [$embed]);
      // insert embed based on index
      } else {
        $this->embeds[$indx] = $embed;
      }
    }
    return $this;
  }

  public function setMessageId($messageId) {
    $this->messageId = $messageId;
    return $this;
  }

  public function getMessage($messageId=null, $copyMsg=true) {
    $webhook = $this->_getWebhookMsgUrl($messageId);
    $curlOpts = $this->_buildCurlOpts();
    $res = $this->_execCurl($webhook, $curlOpts);

    if ($res->success) {
      [
        'id' => $id,
        'content' => $content,
        'author' => $bot,
        'embeds' => $embeds,
        'content' => $content,
        'flags' => $flag,
        'tts' => $tts,
        'attachments' => $attachments,
      ] = $res->body;
      $clone = $this->newMessage();
      $clone->setMessageId($id);
      if ($copyMsg) {
        $clone
          ->setContent($content)
          ->setUsername($bot['username'])
          ->setTts($tts)
          ->setFlag($flag);
        $avatar = $bot['avatar'] ?? '';
        $avatarUrl = 'https://cdn.discordapp.com/avatars/'.$bot["id"].'/'.$avatar.'.png';
        if ($avatar) $clone->setAvatar($avatarUrl);
        if ($attachments) $clone->addAttachments(...$attachments);
        if ($embeds) {
          $mainEmbed = array_splice($embeds, 0, 1);
          // $i+1? index 0 is for main embed
          foreach ($embeds as $i => $embed) $clone->embeds[$i+1] = $embed;
          if ($mainEmbed) {
            $e = $mainEmbed[0];
            if (isset($e['url'])) $clone->setUrl($e['url']);
            if (isset($e['title'])) $clone->setTitle($e['title']);
            if (isset($e['description'])) $clone->setDescription($e['description']);
            if (isset($e['color'])) $clone->setColor($e['color']);
            if (isset($e['timestamp'])) $clone->setTimestamp($e['timestamp']);
            if (isset($e['author'])) $clone->setAuthor($e['author']);
            if (isset($e['image'])) $clone->setImage($e['image']);
            if (isset($e['thumbnail'])) $clone->setThumbnail($e['thumbnail']);
            if (isset($e['footer'])) $clone->setFooter($e['footer']);
            if (isset($e['fields'])) $clone->addFields(...$e['fields']);
          }
        }
      }
    }

    return $clone ?? null;
  }

  public function get($messageId=null) {
    $webhook = $this->_getWebhookMsgUrl($messageId);

    $curlOpts = $this->_buildCurlOpts();

    return $this->_execCurl($webhook, $curlOpts);
  }

  public function delete($messageId=null) {
    $webhook = $this->_getWebhookMsgUrl($messageId);

    $curlOpts = $this->_buildCurlOpts([
      CURLOPT_CUSTOMREQUEST => 'DELETE',
    ]);

    return $this->_execCurl($webhook, $curlOpts);
  }

  public function update($messageId=null) {
    $webhook = $this->_getWebhookMsgUrl($messageId);

    $curlOpts = $this->_buildCurlOpts([ CURLOPT_CUSTOMREQUEST => 'PATCH' ] + $this->_getPostCurlOpts());

    return $this->_execCurl($webhook, $curlOpts);
  }

  public function send($opts=null) {
    $this->_setOpts($opts);

    $webhook = $this->_buildWebhookQuery($this->_getWebhook());

    if (!$this->content && !$this->embed && !$this->embeds && !$this->files) throw new Exception("You must provide a value for at least one of content, embeds, or files.");
    $curlOpts = $this->_buildCurlOpts([ CURLOPT_POST => true ] + $this->_getPostCurlOpts());

    return $this->_execCurl($webhook, $curlOpts);
  }

}

?>
