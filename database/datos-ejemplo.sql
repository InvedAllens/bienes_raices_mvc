-- =====================================================================
--  Datos de ejemplo (opcional): 2 vendedores y 5 propiedades que usan las fotos
--  que ya vienen en public/imagenes/. Ejecutalo DESPUES de schema.sql:
--      mysql -u root -p bienesraices < database/datos-ejemplo.sql
-- =====================================================================

INSERT INTO vendedores (nombre, apellido, telefono) VALUES
  ('Laura', 'Gomez', '5551234567'),
  ('Mario', 'Ruiz',  '5557654321');

INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_idvendedor) VALUES
  ('Residencia moderna con terraza',  4850000, '09b0e345f2072c4cb488d3f3a0cd6a54.jpg',
   'Residencia de diseño contemporáneo con amplias terrazas de cristal, acabados de lujo y jardín tropical a unos pasos de la playa.', 4, 3, 2, CURDATE(), 1),
  ('Casa en el lago con jardin',      3200000, '2d96ec3e2ecd60179cb2fa9bc2d1ae07.jpg',
   'Hermosa casa frente al lago con vista a las montañas, jardín con rocas decorativas y un ambiente tranquilo ideal para descansar.', 3, 2, 2, CURDATE(), 2),
  ('Casa familiar en zona residencial', 2150000, '2eac5cea78e33abae7c771a28ac0edf5.jpg',
   'Casa de dos niveles en fraccionamiento seguro, cochera para dos autos, cocina integral y espacios amplios para toda la familia.', 3, 2, 2, CURDATE(), 1),
  ('Cabaña de lujo con alberca',      5900000, '64975fec5884930c3a58748a257ec0ee.jpg',
   'Espectacular cabaña de madera y piedra con alberca, terraza iluminada y áreas de descanso. Perfecta como casa de campo o inversión.', 5, 4, 3, CURDATE(), 2),
  ('Casa clasica de ladrillo',        1750000, 'd76acb941124733f908dde2c4498fa1a.jpg',
   'Casa clásica de ladrillo con árboles frondosos, cochera frontal y excelente ubicación cerca de escuelas, comercios y parques.', 3, 2, 1, CURDATE(), 1);
