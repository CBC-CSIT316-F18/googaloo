/* Insert User Code */

INSERT INTO `users` (
  `type`,
  `username`,
  `email`,
  `pass`,
  `first_name`,
  `last_name`,
  `date_expires`,
  `date_created`,
  `date_modified`
) VALUES (
  1,
  'username',
  'user@email.com',
  0x70617373776f7264,
  'FirstName',
  'LastName',
  NULL,
  CURRENT_TIMESTAMP,
  CURRENT_TIMESTAMP
);

/* Insert Basic User Example */

INSERT INTO `users` (
  `username`,
  `email`,
  `pass`,
  `first_name`,
  `last_name`
) VALUES (
  'standarduser',
  'standard@mail.com',
  0x70617373776f7264,
  'Stan',
  'Dard'
)


/*  login I can remember  */
INSERT INTO users (
  type, 
  username, 
  email, 
  pass, 
  first_name, 
  last_name, 
  date_expires, 
  date_created, 
  date_modified
) VALUES (
  '0', 
  'TheTyckoMan', 
  'TheTyckoMan@gmail.com',
  '$2y$10$DbHKZE22h0PKWmqwz0emFOC2mdoLFPB53FPHnu.tRR5b6iGNVTNC.', 
  'Tycko', 
  'Franklin',
  NULL, 
  CURRENT_TIMESTAMP, 
  CURRENT_TIMESTAMP
) 