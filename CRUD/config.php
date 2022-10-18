<?php
/*
Script para conectarnos a MySQL y crear la base de datos usando la interfaz PDO.
Mediante un array (db) de configuración con todos nuestros datos para la conexión
*/
return [
  'db' => [
    'host' => 'miweb.localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'tutorial_crud',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];