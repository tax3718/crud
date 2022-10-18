/*
Script es crear la base de datos. Usamos la sentencia use para seleccionar la base de datos que hemos creado
y luego creamos la tabla alumnos junto a sus campos.
En el ejemplo esta consulta es probada primero desde la sección SQL de phpMyAdmin.
Luego es eliminada la base de datos y la tabla para que sea creada directamente desde el código.
*/

CREATE DATABASE tutorial_crud;

use tutorial_crud;

CREATE TABLE alumnos (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  edad INT(3),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);