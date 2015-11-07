<?php
use Pheal\Pheal;
use Pheal\Core\Config;

$phealConfig = Config::getInstance();
$phealConfig->access = new \Pheal\Access\StaticCheck();
$phealConfig->rateLimiter = new \Pheal\RateLimiter\FileLockRateLimiter('var/phealng');
$phealConfig->http_user_agent = "EVE Composition Planer";
$phealConfig->http_ssl_verifypeer = false;

?>