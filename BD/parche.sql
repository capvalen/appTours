--2.220
ALTER TABLE `promociones` 
ADD COLUMN `alcance` ENUM('individual', 'pais', 'departamento', 'ciudad') 
  NOT NULL DEFAULT 'individual' 
  COMMENT 'Alcance del descuento' AFTER `imagen`,
ADD COLUMN `pais_id` INT DEFAULT 140 AFTER `alcance`,
ADD COLUMN `departamento` VARCHAR(100) DEFAULT NULL AFTER `pais_id`,
ADD COLUMN `ciudad` VARCHAR(100) DEFAULT NULL AFTER `departamento`;

--v. 2.6
CREATE TABLE promociones (
	id        INT PRIMARY KEY AUTO_INCREMENT,
	promocion    VARCHAR(100) NOT NULL,  -- ej: "Descuento Familiar", "Promo Verano"
	tipo      ENUM('porcentaje', 'monto', 'combo') NOT NULL,
	valor     DECIMAL(10,2) NOT NULL, -- ej: 15.00 (15%) o 30.00 (S/30)
	inicio        DATE,
	fin           DATE,
	imagen           varchar(255) null,
	activo              BOOLEAN DEFAULT TRUE
);


ALTER TABLE `descuentos`
ADD CONSTRAINT `fk_descuentos_tour` 
FOREIGN KEY (id_tour) REFERENCES tours(id); 
ALTER TABLE `pedidos` ADD `descuento` DECIMAL(10,2) NULL DEFAULT '0' AFTER `precMenor`;
ALTER TABLE `pedidos` ADD `tipo_descuento` ENUM('monto','porcentaje','combo') NOT NULL DEFAULT 'monto' AFTER `descuento`;

ALTER TABLE `descuentos` CHANGE `valor_descuento` `valor_descuento` VARCHAR(10) NOT NULL;
ALTER TABLE `promociones` CHANGE `valor` `valor` VARCHAR(10) NOT NULL;
ALTER TABLE `descuentos` CHANGE `tipo_descuento` `tipo_descuento` ENUM('porcentaje','monto','combo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `descuentos` ADD `promocion_id` INT NOT NULL AFTER `id_tour`;

--v. 2.5
CREATE TABLE descuentos (
	id_descuento        INT PRIMARY KEY AUTO_INCREMENT,
	id_tour         INT NOT NULL,
	nombre_descuento    VARCHAR(100) NOT NULL,  -- ej: "Descuento Familiar", "Promo Verano"
	tipo_descuento      ENUM('porcentaje', 'monto') NOT NULL,
	valor_descuento     DECIMAL(10,2) NOT NULL, -- ej: 15.00 (15%) o 30.00 (S/30)
	fecha_inicio        DATE,
	fecha_fin           DATE,
	activo              BOOLEAN DEFAULT TRUE
);
ALTER TABLE `descuentos` CHANGE `id_descuento` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `descuentos`
ADD CONSTRAINT `fk_descuentos_tour` 
FOREIGN KEY (id_tour) REFERENCES tours(id); 
ALTER TABLE `pedidos` ADD `descuento` DECIMAL(10,2) NULL DEFAULT '0' AFTER `precMenor`;
ALTER TABLE `pedidos` ADD `tipo_descuento` ENUM('monto','porcentaje') NOT NULL DEFAULT 'monto' AFTER `descuento`;