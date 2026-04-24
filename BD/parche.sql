CREATE TABLE descuentos (
	id_descuento        INT PRIMARY KEY AUTO_INCREMENT,
	id_tour         INT NOT NULL,
	nombre_descuento    VARCHAR(100) NOT NULL,  -- ej: "Descuento Familiar", "Promo Verano"
	tipo_descuento      ENUM('porcentaje', 'monto') NOT NULL,
	valor_descuento     DECIMAL(10,2) NOT NULL, -- ej: 15.00 (15%) o 30.00 (S/30)
	fecha_inicio        DATE,
	fecha_fin           DATE,
	activo              BOOLEAN DEFAULT TRUE,
	FOREIGN KEY (id_tour) REFERENCES tours(id)
);
ALTER TABLE `descuentos` CHANGE `id_descuento` `id` INT(11) NOT NULL AUTO_INCREMENT; 