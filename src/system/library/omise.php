<?php
// Define version of Omise-OpenCart
if (!defined('OMISE_OPENCART_VERSION'))
    define('OMISE_OPENCART_VERSION', '2.0.0.0');

$opencart_version = defined('VERSION') ? " OpenCart/".VERSION : "";

// Define 'OMISE_USER_AGENT_SUFFIX'
if (!defined('OMISE_USER_AGENT_SUFFIX'))
    define('OMISE_USER_AGENT_SUFFIX', "OmiseOpenCart/".OMISE_OPENCART_VERSION.$opencart_version);

// Define 'OMISE_API_VERSION'
if(!defined('OMISE_API_VERSION'))
    define('OMISE_API_VERSION', '2014-07-27');
?>