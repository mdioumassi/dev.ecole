<?php
// auto-generated by sfSecurityConfigHandler
// date: 2015/08/30 09:38:00
$this->security = array (
  'newfirst' => 
  array (
    'is_secure' => false,
  ),
  'firstcreate' => 
  array (
    'is_secure' => false,
  ),
  'endregistration' => 
  array (
    'is_secure' => false,
  ),
  'search' => 
  array (
    'ccredentials' => 'list_membre',
  ),
  'create' => 
  array (
    'credentials' => 'add_membre',
  ),
  'new' => 
  array (
    'credentials' => 'add_membre',
  ),
  'delete' => 
  array (
    'credentials' => 'del_membre',
  ),
  'requestsubscription' => 
  array (
    'is_secure' => false,
  ),
  'createpending' => 
  array (
    'is_secure' => false,
  ),
  'pending' => 
  array (
    'is_secure' => false,
  ),
  'validate' => 
  array (
    'credentials' => 'edit_membre',
  ),
  'all' => 
  array (
    'is_secure' => true,
  ),
);
