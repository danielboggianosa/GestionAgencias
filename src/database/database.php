<?php 
$tablas = array(
  "pdm_correo" => "CREATE TABLE IF NOT EXISTS `pdm_correo` (
    `pdm_correo_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_correo_tabla` VARCHAR(150) NOT NULL,
    `pdm_correo_tabla_ID` INT NOT NULL,
    `pdm_correo_correo` VARCHAR(150) NULL,
    PRIMARY KEY (`pdm_correo_id`));",

  "pdm_direccion" => "CREATE TABLE IF NOT EXISTS `pdm_direccion` (
    `pdm_direccion_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_direccion_tabla` VARCHAR(150) NOT NULL,
    `pdm_direccion_tabla_ID` INT NOT NULL,
    `pdm_direccion_nombre` VARCHAR(150) NULL,
    `pdm_direccion_distrito` VARCHAR(150) NULL,
    `pdm_direccion_ciudad` VARCHAR(200) NOT NULL,
    `pdm_direccion_pais` VARCHAR(200) NULL,
    PRIMARY KEY (`pdm_direccion_id`));",

  "pdm_identificacion" => "CREATE TABLE IF NOT EXISTS `pdm_identificacion` (
    `pdm_identificacion_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_identificacion_tabla` VARCHAR(45) NOT NULL,
    `pdm_identificacion_tabla_ID` INT NOT NULL,
    `pdm_identificacion_tipo` VARCHAR(45) NULL,
    `pdm_identificacion_numero` VARCHAR(60) NOT NULL,
    `pdm_identificacion_pais` VARCHAR(200) NULL,
    `pdm_identificacion_emision` DATE NULL,
    `pdm_identificacion_vencimiento` DATE NULL,
    `pdm_identificacion_nota` TEXT NULL,
    `pdm_identificacion_foto` VARCHAR(200) NULL,
    PRIMARY KEY (`pdm_identificacion_id`));",

  "pdm_telefono" => "CREATE TABLE IF NOT EXISTS `pdm_telefono` (
    `pdm_telefono_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_telefono_tabla` VARCHAR(80) NOT NULL,
    `pdm_telefono_tabla_ID` INT NOT NULL,
    `pdm_telefono_numero` VARCHAR(80) NULL,
    PRIMARY KEY (`pdm_telefono_id`));",

  "pdm_itinerario" => "CREATE TABLE IF NOT EXISTS `pdm_itinerario` (
    `pdm_itinerario_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_itinerario_nombre` VARCHAR(200) NOT NULL,
    `pdm_itinerario_moneda` VARCHAR(10) NULL,
    `pdm_itinerario_creado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `pdm_itinerario_modificado` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
    `pdm_itinerario_usuario_ID` INT(11) NOT NULL,
    PRIMARY KEY (`pdm_itinerario_id`));",

  "pdm_operador" => "CREATE TABLE IF NOT EXISTS `pdm_operador` (
    `pdm_operador_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_operador_nombre` VARCHAR(200) NOT NULL,
    `pdm_operador_tipo` VARCHAR(200) NULL,
    `pdm_operador_doc_tipo` VARCHAR(20) NULL,
    `pdm_operador_doc_numero` VARCHAR(100) NULL,
    `pdm_operador_descripcion` TEXT NULL,
    `pdm_operador_etiquetas` TEXT NULL,
    `pdm_operador_creado` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`pdm_operador_id`));",

  "pdm_contacto" => "CREATE TABLE IF NOT EXISTS `pdm_contacto` (
    `pdm_contacto_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_contacto_nombres` VARCHAR(150) NOT NULL,
    `pdm_contacto_apellidos` VARCHAR(150) NULL,
    `pdm_contacto_nacionalidad` VARCHAR(200) NULL,
    `pdm_contacto_fuente` VARCHAR(200) NULL,
    `pdm_contacto_estado` VARCHAR(200) NULL,
    `pdm_contacto_genero` VARCHAR(50) NULL,
    `pdm_contacto_nacimiento` DATE NULL,
    `pdm_contacto_notas` TEXT NULL,
    `pdm_contacto_etiquetas` TEXT NULL,
    `pdm_contacto_foto` VARCHAR(200) NULL,
    `pdm_contacto_creado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`pdm_contacto_id`));",

  "pdm_servicio" => "CREATE TABLE IF NOT EXISTS `pdm_servicio` (
    `pdm_servicio_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_servicio_hora_inicio` TIME NULL,
    `pdm_servicio_hora_final` TIME NULL,
    `pdm_servicio_nombre` VARCHAR(200) NOT NULL,
    `pdm_servicio_descripcion` TEXT NULL,
    `pdm_servicio_foto` TEXT NULL,
    `pdm_servicio_moneda` VARCHAR(50) NULL,
    `pdm_servicio_costo` DECIMAL(10,2) NULL,
    `pdm_servicio_precio` DECIMAL(10,2) NULL,
    `pdm_servicio_operador_ID` INT NOT NULL,
    PRIMARY KEY (`pdm_servicio_id`));",

  "pdm_solicitud" => "CREATE TABLE IF NOT EXISTS `pdm_solicitud` (
    `pdm_solicitud_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_solicitud_inicio` DATETIME NULL,
    `pdm_solicitud_fin` DATETIME NULL,
    `pdm_solicitud_usuario` INT NULL,
    `pdm_solicitud_responsable` INT NULL,
    `pdm_solicitud_estado` VARCHAR(45) NULL,
    `pdm_solicitud_pasajero_ID` INT NULL,
    `pdm_solicitud_servicios` VARCHAR(150) NULL,
    `pdm_solicitud_fecha_tipo` VARCHAR(20) NULL,
    `pdm_solicitud_fecha_salida` DATE NULL,
    `pdm_solicitud_fecha_retorno` DATE NULL,
    `pdm_solicitud_origen` VARCHAR(150) NULL,
    `pdm_solicitud_destino` VARCHAR(150) NULL,
    `pdm_solicitud_cantidad_adt` INT NULL,
    `pdm_solicitud_cantidad_chd` INT NULL,
    `pdm_solicitud_cantidad_inf` INT NULL,
    `pdm_solicitud_descripcion` TEXT NULL,
    PRIMARY KEY (`pdm_solicitud_id`));",

  "pdm_solicitud_historial" => "CREATE TABLE IF NOT EXISTS `pdm_solicitud_historial` (
    `pdm_solicitud_historial_id` INT NOT NULL AUTO_INCREMENT,
    `pdm_solicitud_historial_usuario` INT NULL,
    `pdm_solicitud_historial_fecha` DATETIME NULL,
    `pdm_solicitud_historial_comentario` TEXT NULL,
    `pdm_solicitud_historial_solID` INT NULL,
    PRIMARY KEY (`pdm_solicitud_historial_id`));",

  "pdm_soliti" => "CREATE TABLE IF NOT EXISTS `pdm_soliti` (
    `pdm_soliti_solicitud_ID` INT NOT NULL,
    `pdm_soliti_itinerario_ID` INT NOT NULL);",

  "pdm_itidet" => "CREATE TABLE IF NOT EXISTS `pdm_itidet` (
    `pdm_itidet_itinerario_ID` INT NOT NULL,
    `pdm_itidet_dia` INT NOT NULL,
    `pdm_itidet_servicio_ID` INT NOT NULL);",

  "pdm_historial" => "CREATE TABLE IF NOT EXISTS pdm_historial (
    pdm_historial_id INT NOT NULL AUTO_INCREMENT,
    pdm_historial_tabla VARCHAR(150) NOT NULL,
    pdm_historial_tabla_ID INT NOT NULL,
    pdm_historial_creado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    pdm_historial_modificado TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    pdm_historial_usuario INT NOT NULL,
    pdm_historial_contenido TEXT NOT NULL,
    PRIMARY KEY (pdm_historial_id));",

  "pdm_resgistro" => "CREATE TABLE IF NOT EXISTS pdm_registro (
    pdm_registro_id INT NOT NULL AUTO_INCREMENT,
    pdm_registro_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    pdm_registro_contenido TEXT NOT NULL,
    pdm_registro_usuario INT NOT NULL,
    PRIMARY KEY (pdm_registro_id));",
);

