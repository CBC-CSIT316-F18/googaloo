/* Insert User Code */

INSERT INTO `user` (`type`, `username`, `email`, `pass`, `first_name`, `last_name`, `date_expires`, `date_created`, `date_modified`)
VALUES 
('administrator', 'username', 'user@email.com',0x70617373776f7264, 'FirstName', 'LastName', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

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
