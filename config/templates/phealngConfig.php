<?php
use Pheal\Pheal;
use Pheal\Core\Config;

Config::getInstance()->cache = new \Pheal\Cache\PdoStorage('mysql:host=@db.host@;dbname=@db.name.ecp@', '@db.user@', '@db.pass@', 'phealng-cache', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'@db.charset@\''));
?>