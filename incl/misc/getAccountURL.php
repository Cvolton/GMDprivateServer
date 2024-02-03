<?php
$host = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8');
$request_uri = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$host$request_uri";
echo dirname($url);