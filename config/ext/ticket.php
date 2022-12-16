<?php
if(!defined('TABLE_TICKET')) define('TABLE_TICKET', '`' . $config->db->prefix . 'ticket`');
if(!defined('TABLE_TICKETSOURCE')) define('TABLE_TICKETSOURCE', '`' . $config->db->prefix . 'ticketsource`');
if(!defined('TABLE_TICKETRELATION')) define('TABLE_TICKETRELATION', '`' . $config->db->prefix . 'ticketrelation`');

$config->objectTables['ticket'] = TABLE_TICKET;
$config->objectTables['ticketsource'] = TABLE_TICKETSOURCE;
