-- ============================================================
--  Registro de cuentas de usuario (panel de usuario)
--  Base de datos: grupoeuroapp
--  (la misma que usa api/conectkarl.php)
--
--  Ejecutar una sola vez:
--    mysql -u root -p grupoeuroapp < cuentas_usuarios.sql
-- ============================================================

CREATE TABLE IF NOT EXISTS `cuentas` (
  `id`         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `apellidos`  VARCHAR(100)  NULL,                   -- NULL mientras el usuario de Google completa su perfil
  `nombres`    VARCHAR(100)  NULL,                   -- NULL mientras el usuario de Google completa su perfil
  `correo`     VARCHAR(150)  NOT NULL,
  `password`   VARCHAR(255)  NULL,                   -- NULL si la cuenta se creó con Google
  `google_uid` VARCHAR(255)  NULL,                   -- UID de Firebase/Google (sub)
  `foto`       VARCHAR(255)  NULL,                   -- foto de perfil de Google
  `proveedor`  ENUM('local','google') NOT NULL DEFAULT 'local',
  `activo`     TINYINT(1)    NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_cuentas_correo` (`correo`),
  UNIQUE KEY `uk_cuentas_google_uid` (`google_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
--  MIGRACIÓN: ejecuta este bloque SOLO si ya habías creado la
--  tabla `cuentas` antes de agregar el login con Google.
--  (MariaDB 10.5+ / MySQL 8.0.29+ admiten IF NOT EXISTS)
-- ------------------------------------------------------------
-- ALTER TABLE `cuentas`
--   MODIFY `apellidos` VARCHAR(100) NULL,
--   MODIFY `nombres`   VARCHAR(100) NULL,
--   MODIFY `password`  VARCHAR(255) NULL;
--
-- ALTER TABLE `cuentas`
--   ADD COLUMN `google_uid` VARCHAR(255) NULL AFTER `password`,
--   ADD COLUMN `foto`       VARCHAR(255) NULL AFTER `google_uid`,
--   ADD COLUMN `proveedor`  ENUM('local','google') NOT NULL DEFAULT 'local' AFTER `foto`;
--
-- ALTER TABLE `cuentas`
--   ADD UNIQUE KEY `uk_cuentas_google_uid` (`google_uid`);

-- ------------------------------------------------------------
--  (Opcional) Cuenta de prueba
--  La contraseña NO se guarda en texto plano, sino con password_hash().
--  Genera el hash así:
--      php -r "echo password_hash('123456', PASSWORD_DEFAULT);"
--  y pega el resultado en el VALUES.
-- ------------------------------------------------------------
-- INSERT INTO `cuentas` (`apellidos`, `nombres`, `correo`, `password`)
-- VALUES ('Prueba', 'Usuario', 'prueba@correo.com', '$2y$10$REEMPLAZA_ESTE_HASH');
