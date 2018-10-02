--
-- Database: `ecommerce2`
--

-- Do not run this page in batch mode!
-- There are a couple of stored procedures that get redefined.
-- Either edit this SQL file accordingly, then run it in batch mode, or copy and paste commands as needed.

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--
USE ecommerce2;

CREATE TABLE `carts` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_id` CHAR(32) NOT NULL,
  `product_type` enum('coffee','goodies') NOT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY `user_session_id` (`user_session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(80) NOT NULL,
  `first_name` VARCHAR(20) NOT NULL,
  `last_name` VARCHAR(40) NOT NULL,
  `address1` VARCHAR(80) NOT NULL,
  `address2` VARCHAR(80) DEFAULT NULL,
  `city` VARCHAR(60) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` MEDIUMINT(5) UNSIGNED ZEROFILL NOT NULL,
  `phone` CHAR(10) NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_coffees`
--

CREATE TABLE `general_coffees` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(40) NOT NULL,
  `description` TINYTEXT,
  `image` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_coffees`
--

INSERT INTO `general_coffees` VALUES(1, 'Original Blend', 'Our original blend, featuring a quality mixture of bean and a medium roast for a rich color and smooth flavor.', 'original_coffee.jpg');
INSERT INTO `general_coffees` VALUES(2, 'Dark Roast', 'Our darkest, non-espresso roast, with a full flavor and a slightly bitter aftertaste.', 'dark_roast.jpg');
INSERT INTO `general_coffees` VALUES(3, 'Kona', 'A real treat! Kona coffee, fresh from the lush mountains of Hawaii. Smooth in flavor and perfectly roasted!', 'kona.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `non_coffee_categories`
--

CREATE TABLE `non_coffee_categories` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(40) NOT NULL,
  `description` TINYTEXT NOT NULL,
  `image` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `non_coffee_categories`
--

INSERT INTO `non_coffee_categories` VALUES(1, 'Edibles', 'A wonderful assortment of goodies to eat. Includes biscotti, baklava, lemon bars, and more!', 'goodies.jpg');
INSERT INTO `non_coffee_categories` VALUES(2, 'Gift Baskets', 'Gift baskets for any occasion! Including our many coffees and other goodies.', 'gift_basket.jpg');
INSERT INTO `non_coffee_categories` VALUES(3, 'Mugs', 'A selection of lovely mugs for enjoying your coffee, tea, hot cocoa or other hot beverages.', '781426_32573620.jpg');
INSERT INTO `non_coffee_categories` VALUES(4, 'Books', 'Our recommended books about coffee, goodies, plus anything written by Larry Ullman!', 'books.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `non_coffee_products`
--

CREATE TABLE `non_coffee_products` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `non_coffee_category_id` TINYINT(3) UNSIGNED NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `description` TINYTEXT,
  `image` VARCHAR(45) NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `stock` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `non_coffee_category_id` (`non_coffee_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `non_coffee_products`
--

INSERT INTO `non_coffee_products` (`non_coffee_category_id`, `name`, `description`, `image`, `price`, `stock`, `date_created`) VALUES
(3, 'Pretty Flower Coffee Mug', 'A pretty coffee mug with a flower design on a white background.', 'd9996aee5639209b3fb618b07e10a34b27baad12.jpg', 650, 100, NOW()),
(3, 'Red Dragon Mug', 'An elaborate, painted gold dragon on a red background. With partially detached, fancy handle.', '847a1a3bef0fb5c2f2299b06dd63669000f5c6c4.jpg', 795, 4, NOW());

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` INT(10) UNSIGNED NOT NULL,
  `total` INT(10) UNSIGNED DEFAULT NULL,
  `shipping` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `credit_card_number` MEDIUMINT(4) ZEROFILL UNSIGNED NOT NULL,
  `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_date` (`order_date`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE `order_contents` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `price_per` INT(10) UNSIGNED NOT NULL,
  `ship_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ship_date` (`ship_date`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `start_date` (`start_date`),
  KEY `product_type` (`product_type`,`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`product_type`, `product_id`, `price`, `start_date`, `end_date`) VALUES
('goodies', 1, 500, '2013-08-16', '2013-10-31'),
('coffee', 7, 700, '2013-08-19', NULL),
('coffee', 9, 1300, '2013-08-19', '2013-08-26'),
('goodies', 2, 700, '2013-08-22', NULL),
('coffee', 8, 1300, '2013-08-22', '2013-10-31'),
('coffee', 10, 3000, '2013-08-22', '2013-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `size` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `size` (`size`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` VALUES(1, '2 oz. Sample');
INSERT INTO `sizes` VALUES(2, 'Half Pound');
INSERT INTO `sizes` VALUES(3, '1 lb.');
INSERT INTO `sizes` VALUES(4, '2 lbs.');
INSERT INTO `sizes` VALUES(5, '5 lbs.');

-- --------------------------------------------------------

--
-- Table structure for table `specific_coffees`
--

CREATE TABLE `specific_coffees` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `general_coffee_id` TINYINT(3) UNSIGNED NOT NULL,
  `size_id` TINYINT(3) UNSIGNED NOT NULL,
  `caf_decaf` enum('caf','decaf') DEFAULT NULL,
  `ground_whole` enum('ground','whole') DEFAULT NULL,
  `price` INT(10) UNSIGNED NOT NULL,
  `stock` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `general_coffee_id` (`general_coffee_id`),
  KEY `size` (`size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specific_coffees`
--

INSERT INTO `specific_coffees` (`general_coffee_id`, `size_id`, `caf_decaf`, `ground_whole`, `price`, `stock`, `date_created`) VALUES
(3, 1, 'caf', 'ground', 200, 20, NOW()),
(3, 2, 'caf', 'ground', 450, 30, NOW()),
(3, 2, 'decaf', 'ground', 500, 20, NOW()),
(3, 3, 'caf', 'ground', 800, 50, NOW()),
(3, 3, 'decaf', 'ground', 850, 20, NOW()),
(3, 3, 'caf', 'whole', 750, 50, NOW()),
(3, 3, 'decaf', 'whole', 800, 20, NOW()),
(3, 4, 'caf', 'whole', 1500, 30, NOW()),
(3, 4, 'decaf', 'whole', 1550, 15, NOW()),
(3, 5, 'caf', 'whole', 3250, 5, NOW());

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `type` VARCHAR(18) NOT NULL,
  `amount` INT(10) UNSIGNED NOT NULL,
  `response_code` TINYINT(1) UNSIGNED NOT NULL,
  `response_reason` TINYTEXT,
  `transaction_id` BIGINT(20) UNSIGNED NOT NULL,
  `response` TEXT NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wish_lists`
--

CREATE TABLE `wish_lists` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_session_id` char(32) NOT NULL,
  `product_type` enum('coffee','goodies') DEFAULT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `quantity` TINYINT(3) UNSIGNED NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_type` (`product_type`,`product_id`),
  KEY `user_session_id` (`user_session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- -----------------------------
-- Stored Procedures --
-- -----------------------------

DELIMITER $$
CREATE PROCEDURE select_categories (type VARCHAR(7))
BEGIN
IF type = 'coffee' THEN
SELECT * FROM general_coffees ORDER by category;
ELSEIF type = 'goodies' THEN
SELECT * FROM non_coffee_categories ORDER by category;
END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE select_products(type VARCHAR(7), cat TINYINT)
BEGIN
  IF type = 'coffee' THEN
    SELECT	gc.description, gc.image, CONCAT("C", sc.id) AS sku, 
CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole, CONCAT("$", FORMAT(sc.price/100, 2))) AS name, 
sc.stock 
    FROM specific_coffees AS sc INNER JOIN sizes AS s ON s.id=sc.size_id 
    INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id 
    WHERE general_coffee_id=cat AND stock>0 
    ORDER by name ASC;
	ELSEIF type = 'goodies' THEN
    SELECT ncc.description AS g_description, ncc.image AS g_image, 
    CONCAT("G", ncp.id) AS sku, ncp.name, ncp.description, ncp.image, 
    CONCAT("$", FORMAT(ncp.price/100, 2)) AS price, ncp.stock 
    FROM non_coffee_products AS ncp INNER JOIN non_coffee_categories AS ncc 
    ON ncc.id=ncp.non_coffee_category_id 
    WHERE non_coffee_category_id=cat ORDER by date_created DESC;
	END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE select_sale_items (get_all BOOLEAN)
BEGIN
IF get_all = 1 THEN 
SELECT CONCAT("G", ncp.id) AS sku, sa.price AS sale_price, ncc.category, ncp.image, ncp.name, ncp.price AS price, ncp.stock, ncp.description FROM sales AS sa INNER JOIN non_coffee_products AS ncp ON sa.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id WHERE sa.product_type="goodies" AND ((NOW() BETWEEN sa.start_date AND sa.end_date) OR (NOW() > sa.start_date AND sa.end_date IS NULL) )
UNION SELECT CONCAT("C", sc.id), sa.price, gc.category, gc.image, CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole), sc.price, sc.stock, gc.description FROM sales AS sa INNER JOIN specific_coffees AS sc ON sa.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id WHERE sa.product_type="coffee" AND ((NOW() BETWEEN sa.start_date AND sa.end_date) OR (NOW() > sa.start_date AND sa.end_date IS NULL) );
ELSE 
(SELECT CONCAT("G", ncp.id) AS sku, CONCAT("$", FORMAT(sa.price/100, 2)) AS sale_price, ncc.category, ncp.image, ncp.name FROM sales AS sa INNER JOIN non_coffee_products AS ncp ON sa.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id WHERE sa.product_type="goodies" AND ((NOW() BETWEEN sa.start_date AND sa.end_date) OR (NOW() > sa.start_date AND sa.end_date IS NULL) ) ORDER BY RAND() LIMIT 2) UNION (SELECT CONCAT("C", sc.id), CONCAT("$", FORMAT(sa.price/100, 2)), gc.category, gc.image, CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole) FROM sales AS sa INNER JOIN specific_coffees AS sc ON sa.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id WHERE sa.product_type="coffee" AND ((NOW() BETWEEN sa.start_date AND sa.end_date) OR (NOW() > sa.start_date AND sa.end_date IS NULL) ) ORDER BY RAND() LIMIT 2);
END IF;
END$$
DELIMITER ;


-- -----------------------------
-- Later in Chapter 8: --
-- -----------------------------

DROP PROCEDURE select_products;
DELIMITER $$
CREATE PROCEDURE select_products(type VARCHAR(7), cat TINYINT)
BEGIN
IF type = 'coffee' THEN
SELECT gc.description, gc.image, CONCAT("C", sc.id) AS sku, 
CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole, CONCAT("$", FORMAT(sc.price/100, 2))) AS name, 
sc.stock, sc.price, sales.price AS sale_price 
FROM specific_coffees AS sc INNER JOIN sizes AS s ON s.id=sc.size_id 
INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id 
LEFT OUTER JOIN sales ON (sales.product_id=sc.id 
AND sales.product_type='coffee' AND 
((NOW() BETWEEN sales.start_date AND sales.end_date) 
OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) 
WHERE general_coffee_id=cat AND stock>0 
ORDER by name;
ELSEIF type = 'goodies' THEN
SELECT ncc.description AS g_description, ncc.image AS g_image, 
CONCAT("G", ncp.id) AS sku, ncp.name, ncp.description, ncp.image, ncp.price, ncp.stock, sales.price AS sale_price
FROM non_coffee_products AS ncp INNER JOIN non_coffee_categories AS ncc 
ON ncc.id=ncp.non_coffee_category_id 
LEFT OUTER JOIN sales ON (sales.product_id=ncp.id 
AND sales.product_type='goodies' AND 
((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) )
WHERE non_coffee_category_id=cat ORDER by date_created DESC;
END IF;
END$$
DELIMITER ;

-- -----------------------------
-- Chapter 9: --
-- -----------------------------

DELIMITER $$
CREATE PROCEDURE update_cart (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT, qty TINYINT)
BEGIN
IF qty > 0 THEN
UPDATE carts SET quantity=qty, date_modified=NOW() WHERE user_session_id=uid AND product_type=type AND product_id=pid;
ELSEIF qty = 0 THEN
CALL remove_from_cart (uid, type, pid);
END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE add_to_cart (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT, qty TINYINT)
BEGIN
DECLARE cid INT;
SELECT id INTO cid FROM carts WHERE user_session_id=uid AND product_type=type AND product_id=pid;
IF cid > 0 THEN
UPDATE carts SET quantity=quantity+qty, date_modified=NOW() WHERE id=cid;
ELSE 
INSERT INTO carts (user_session_id, product_type, product_id, quantity) VALUES (uid, type, pid, qty);
END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE remove_from_cart (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT)
BEGIN
DELETE FROM carts WHERE user_session_id=uid AND product_type=type AND product_id=pid;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_shopping_cart_contents (uid CHAR(32))
BEGIN
SELECT CONCAT("G", ncp.id) AS sku, c.quantity, ncc.category, ncp.name, ncp.price, ncp.stock, sales.price AS sale_price FROM carts AS c INNER JOIN non_coffee_products AS ncp ON c.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id LEFT OUTER JOIN sales ON (sales.product_id=ncp.id AND sales.product_type='goodies' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE c.product_type="goodies" AND c.user_session_id=uid UNION SELECT CONCAT("C", sc.id), c.quantity, gc.category, CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole), sc.price, sc.stock, sales.price FROM carts AS c INNER JOIN specific_coffees AS sc ON c.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id LEFT OUTER JOIN sales ON (sales.product_id=sc.id AND sales.product_type='coffee' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE c.product_type="coffee" AND c.user_session_id=uid;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE update_wish_list (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT, qty TINYINT)
BEGIN
IF qty > 0 THEN
UPDATE wish_lists SET quantity=qty, date_modified=NOW() WHERE user_session_id=uid AND product_type=type AND product_id=pid;
ELSEIF qty = 0 THEN
CALL remove_from_wish_list (uid, type, pid);
END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE add_to_wish_list (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT, qty TINYINT)
BEGIN
DECLARE cid INT;
SELECT id INTO cid FROM wish_lists WHERE user_session_id=uid AND product_type=type AND product_id=pid;
IF cid > 0 THEN
UPDATE wish_lists SET quantity=quantity+qty, date_modified=NOW() WHERE id=cid;
ELSE 
INSERT INTO wish_lists (user_session_id, product_type, product_id, quantity) VALUES (uid, type, pid, qty);
END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE remove_from_wish_list (uid CHAR(32), type VARCHAR(7), pid MEDIUMINT)
BEGIN
DELETE FROM wish_lists WHERE user_session_id=uid AND product_type=type AND product_id=pid;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_wish_list_contents (uid CHAR(32))
BEGIN
SELECT CONCAT("G", ncp.id) AS sku, wl.quantity, ncc.category, ncp.name, ncp.price, ncp.stock, sales.price AS sale_price FROM wish_lists AS wl INNER JOIN non_coffee_products AS ncp ON wl.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id LEFT OUTER JOIN sales ON (sales.product_id=ncp.id AND sales.product_type='goodies' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE wl.product_type="goodies" AND wl.user_session_id=uid UNION SELECT CONCAT("C", sc.id), wl.quantity, gc.category, CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole), sc.price, sc.stock, sales.price FROM wish_lists AS wl INNER JOIN specific_coffees AS sc ON wl.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id LEFT OUTER JOIN sales ON (sales.product_id=sc.id AND sales.product_type='coffee' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE wl.product_type="coffee" AND wl.user_session_id=uid;
END$$
DELIMITER ;

-- -----------------------------
-- Chapter 10 --
-- -----------------------------

DELIMITER $$
CREATE PROCEDURE add_customer (e VARCHAR(80), f VARCHAR(20), l VARCHAR(40), a1 VARCHAR(80), a2 VARCHAR(80), c VARCHAR(60), s CHAR(2), z MEDIUMINT, p INT, OUT cid INT)
BEGIN
  INSERT INTO customers (email, first_name, last_name, address1, address2, city, state, zip, phone) VALUES (e, f, l, a1, a2, c, s, z, p);
	SELECT LAST_INSERT_ID() INTO cid;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE add_order (cid INT, uid CHAR(32), ship INT(10), cc MEDIUMINT, OUT total INT(10), OUT oid INT)
BEGIN
	DECLARE subtotal INT(10);
	INSERT INTO orders (customer_id, shipping, credit_card_number, order_date) VALUES (cid, ship, cc, NOW());
	SELECT LAST_INSERT_ID() INTO oid;
	INSERT INTO order_contents (order_id, product_type, product_id, quantity, price_per) SELECT oid, c.product_type, c.product_id, c.quantity, IFNULL(sales.price, ncp.price) FROM carts AS c INNER JOIN non_coffee_products AS ncp ON c.product_id=ncp.id LEFT OUTER JOIN sales ON (sales.product_id=ncp.id AND sales.product_type='goodies' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE c.product_type="goodies" AND c.user_session_id=uid UNION SELECT oid, c.product_type, c.product_id, c.quantity, IFNULL(sales.price, sc.price) FROM carts AS c INNER JOIN specific_coffees AS sc ON c.product_id=sc.id LEFT OUTER JOIN sales ON (sales.product_id=sc.id AND sales.product_type='coffee' AND ((NOW() BETWEEN sales.start_date AND sales.end_date) OR (NOW() > sales.start_date AND sales.end_date IS NULL)) ) WHERE c.product_type="coffee" AND c.user_session_id=uid;
	SELECT SUM(quantity*price_per) INTO subtotal FROM order_contents WHERE order_id=oid;
	UPDATE orders SET total = (subtotal + ship) WHERE id=oid;
	SELECT (subtotal + ship) INTO total;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_transaction (oid INT, trans_type VARCHAR(18), amt INT(10), rc TINYINT, rrc TINYTEXT, tid BIGINT, r TEXT)
BEGIN
	INSERT INTO transactions VALUES (NULL, oid, trans_type, amt, rc, rrc, tid, r, NOW());
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE clear_cart (uid CHAR(32))
BEGIN
	DELETE FROM carts WHERE user_session_id=uid;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_order_contents (oid INT)
BEGIN
SELECT oc.quantity, oc.price_per, (oc.quantity*oc.price_per) AS subtotal, ncc.category, ncp.name, o.total, o.shipping FROM order_contents AS oc INNER JOIN non_coffee_products AS ncp ON oc.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id INNER JOIN orders AS o ON oc.order_id=o.id WHERE oc.product_type="goodies" AND oc.order_id=oid UNION SELECT oc.quantity, oc.price_per, (oc.quantity*oc.price_per), gc.category, CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole), o.total, o.shipping FROM order_contents AS oc INNER JOIN specific_coffees AS sc ON oc.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id INNER JOIN orders AS o ON oc.order_id=o.id  WHERE oc.product_type="coffee" AND oc.order_id=oid;
END$$
DELIMITER ;


-- -----------------------------
-- Chapter 13 --
-- -----------------------------

CREATE TABLE `reviews` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_type` enum('coffee','goodies') NOT NULL,
  `product_id` MEDIUMINT(8) UNSIGNED NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `review` TEXT NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_type` (`product_type`,`product_id`),
  UNIQUE (`email`, `product_type`, `product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DELIMITER $$
CREATE PROCEDURE add_review (type VARCHAR(7), pid MEDIUMINT, n VARCHAR(60), e VARCHAR(80), r TEXT)
BEGIN
  INSERT INTO reviews (product_type, product_id, name, email, review) VALUES (type, pid, n, e, r);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE select_reviews(type VARCHAR(7), pid MEDIUMINT)
BEGIN
IF type = 'coffee' THEN
SELECT review FROM reviews WHERE type='coffee' AND product_id=pid ORDER by date_created DESC;
ELSEIF type = 'goodies' THEN
SELECT review FROM reviews WHERE type='goodies' AND product_id=pid ORDER by date_created DESC;
END IF;
END$$
DELIMITER ;


-- -----------------------------
-- Chapter 13 --
-- -----------------------------

CREATE TABLE `charges` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `charge_id` VARCHAR(60) NOT NULL,
  `order_id` INT(10) UNSIGNED NOT NULL,
  `type` VARCHAR(18) NOT NULL,
  `amount` INT(10) UNSIGNED NOT NULL,
  `charge` TEXT NOT NULL,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `charge_id` (`charge_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DELIMITER $$
CREATE PROCEDURE add_charge (charge_id VARCHAR(60), oid INT, trans_type VARCHAR(18), amt INT(10), charge TEXT)
BEGIN
  INSERT INTO charges VALUES (NULL, charge_id, oid, trans_type, amt, charge, NOW());
END$$
DELIMITER ;

