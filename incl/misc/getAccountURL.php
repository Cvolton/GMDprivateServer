<?php
if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) $https = 'https';
else $https = 'http';
echo dirname($https."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
?>