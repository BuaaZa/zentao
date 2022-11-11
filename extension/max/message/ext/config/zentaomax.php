<?php
$config->message->objectTypes['review']   = array('toaudit');
$config->message->objectTypes['approval'] = array('cc', 'approval');

$config->message->available['mail']['review']   = $config->message->objectTypes['review'];
$config->message->available['mail']['approval'] = $config->message->objectTypes['approval'];

$config->message->objectTypes['meeting'] = array('opened', 'edited', 'minuted');

$config->message->available['mail']['meeting']    = $config->message->objectTypes['meeting'];
$config->message->available['webhook']['meeting'] = $config->message->objectTypes['meeting'];
