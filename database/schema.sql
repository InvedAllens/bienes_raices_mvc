-- =====================================================================
--  Bienes Raices - esquema de la base de datos (MySQL 5.7+ / MariaDB 10.3+)
--
--  Uso (con una base de datos vacia ya creada, por ejemplo "bienesraices"):
--      mysql -u root -p -e "CREATE DATABASE bienesraices CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
--      mysql -u root -p bienesraices < database/schema.sql
--
--  Despues crea el administrador con:  php database/crear-admin.php correo@ejemplo.com
-- =====================================================================

CREATE TABLE IF NOT EXISTS vendedores (
  idvendedor INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(45) NOT NULL,
  apellido   VARCHAR(45) NOT NULL,
  telefono   VARCHAR(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS propiedades (
  idpropiedad           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo                VARCHAR(45)  NOT NULL,
  precio                DECIMAL(10,2) NOT NULL,
  imagen                VARCHAR(200) NOT NULL,       -- nombre del archivo en public/imagenes/
  descripcion           LONGTEXT     NOT NULL,
  habitaciones          TINYINT UNSIGNED NOT NULL,
  wc                    TINYINT UNSIGNED NOT NULL,
  estacionamiento       TINYINT UNSIGNED NOT NULL,
  creado                DATE         NOT NULL,
  vendedores_idvendedor INT UNSIGNED NOT NULL,
  -- un vendedor con propiedades no se puede borrar hasta quitar o reasignar sus propiedades
  CONSTRAINT fk_propiedades_vendedor FOREIGN KEY (vendedores_idvendedor) REFERENCES vendedores(idvendedor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS usuarios (
  id       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email    VARCHAR(60)  NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL                     -- hash bcrypt (60 caracteres)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
