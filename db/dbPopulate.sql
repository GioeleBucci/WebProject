use test;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`name`) VALUES
('Living Room'),
('Bedroom'),
('Dining Room'),
('Office'),
('Outdoor'),
('Kitchen'),
('Bathroom');

--
-- Dumping data for table `ARTICLE`
--

INSERT INTO `ARTICLE` (`name`, `details`, `material`, `weight`, `basePrice`, `size`, `categoryId`, `image`, `longDescription`) VALUES
('FUKREJIV', '3-seater sofa', 'Fabric', 85.00, 499, '240x160x80 cm', 1, 'sofa.png', 'A comfortable 3-seater sofa with durable fabric upholstery, perfect for relaxing in your living room. Its modern design and sturdy construction make it a great addition to any home.'),
('MÅEYE', 'Round glass coffee table', 'Glass/Metal', 250.00, 79, '90x90x45 cm', 1, 'coffeeTable.png', 'A sleek round coffee table with a tempered glass top and sturdy metal frame, ideal for modern spaces. Its minimalist design complements a variety of interior styles.'),
('KOBNE', 'Tall bookshelf with 5 shelves', 'Oak', 40.00, 199, '180x80x30 cm', 1, 'bookshelf.png', 'A tall oak bookshelf with five spacious shelves, perfect for organizing books and decor items. Its elegant finish adds a touch of sophistication to any room.'),
('LUUYFO', 'Queen size bed frame', 'Walnut', 70.00, 99.90, '160x200 cm', 2, 'bedFrame.png', 'A sturdy queen-size bed frame made of walnut wood, offering both durability and elegance. Its timeless design ensures it blends seamlessly with any bedroom decor.'),
('EDIVPÅSÖ', 'Six-drawer dresser', 'Cherry Wood', 65.00, 299, '120x50x80 cm', 2, 'drawer.png', 'A stylish six-drawer dresser crafted from cherry wood, providing ample storage for your bedroom. Its smooth finish and classic design make it a standout piece.'),
('HORJÅ', 'Expandable dining table', 'Maple', 55.00, 129, '180x90x75 cm', 3, 'tableExpandable.png', 'A versatile dining table made of maple wood, expandable to accommodate more guests with ease. Its robust construction and elegant design make it perfect for family gatherings.'),
('KEPSÖ', 'Upholstered dining chair', 'Oak/Fabric', 80.00, 49.90, '45x55x95 cm', 3, 'chair.png', 'A comfortable dining chair with oak legs and fabric upholstery, perfect for any dining room. Its ergonomic design ensures long-lasting comfort during meals.'),
('TÖDHIAFJI', 'Office desk with drawers', 'Mahogany', 6.00, 159, '160x80x75 cm', 4, 'desk.png', 'A spacious office desk with built-in drawers, crafted from mahogany for a professional look. Its ample workspace and storage options make it ideal for productivity.'),
('PUPYIDRÅ', 'Ergonomic office chair', 'Mesh/Metal', 15.00, 109.90, '65x65x120 cm', 4, 'chairOffice.png', 'An ergonomic office chair with breathable mesh and adjustable features for all-day comfort. Its sleek design and sturdy build make it a must-have for any workspace.'),
('LEPNA', 'Outdoor table with 2 chairs', 'Aluminum', 15.50, 79, '100x100 cm', 5, 'tableOutdoor.png', 'A durable outdoor table set with two aluminum chairs, perfect for enjoying meals in your garden or patio. Its weather-resistant materials ensure long-lasting use in any outdoor setting.');

--
-- Dumping data for table `ARTICLE_VERSION`
--

INSERT INTO `ARTICLE_VERSION` (`articleId`, `versionId`, `features`, `priceVariation`, `availability`) VALUES
(1, 1, 'Gray Fabric', 0, 5),
(1, 2, 'Blue Fabric', 0, 3),
(1, 3, 'Beige Fabric', 0, 7),
(2, 1, 'Clear Glass', 0, 10),
(2, 2, 'Smoked Glass', 5, 6),
(3, 1, 'Natural Finish', 0, 8),
(3, 2, 'Dark Finish', 0, 4),
(4, 1, 'Natural Finish', 0, 3),
(4, 2, 'Dark Finish', 0, 5),
(5, 1, 'White', 0, 4),
(5, 2, 'Cherry Finish', 7.90, 2),
(6, 1, 'Natural Finish', 0, 3),
(6, 2, 'Espresso Finish', 9.90, 2),
(7, 1, 'Gray Fabric', 0, 12),
(7, 2, 'Beige Fabric', 0, 8),
(8, 1, 'Natural Finish', 0, 2),
(8, 2, 'Dark Finish', 0, 3),
(9, 1, 'Black', 0, 7),
(9, 2, 'Gray', 0, 5),
(10, 1, 'Natural Finish', 0, 2);

--
-- Dumping data for table `PAYMENT_METHOD`
--

INSERT INTO `PAYMENT_METHOD` (`name`) VALUES
('Credit Card'),
('PayPal'),
('Cash on Delivery'),
('Bank Transfer'),
('Store Credit');

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`email`, `password`, `address`, `phoneNumber`, `name`, `birthDate`) VALUES
('emma@example.com', 'password', '123 Oak St, Furnitureville, US', '555-123-4567', 'Emma Johnson', '1985-05-15'),
('seller1@shop.com', 'password', '200 Retail Blvd, Shopville, US', '555-333-4444', 'Home Elegance', '1982-07-17'),
('seller2@shop.com', 'password', '100 Commerce Way, Market City, US', '555-111-2222', 'Lux Furniture', '1975-01-10'),
('michael@example.com', 'password', '456 Maple Ave, Hometown, US', '555-987-6543', 'Michael Brown', '1978-11-22'),
('olivia@example.com', 'password', '789 Pine Rd, Decor City, US', '555-555-1212', 'Olivia Smith', '1990-08-30');

--
-- Dumping data for table `SELLER`
--

INSERT INTO `SELLER` (`userId`, `deliveredOrders`) VALUES
(2, 178),
(3, 205);

--
-- Dumping data for table `CLIENT`
--
INSERT INTO `CLIENT` (`userId`, `paymentMethodId`) VALUES
(1, 1),
(4, 2),
(5, 3);

--
-- Dumping data for table `CLIENT_ORDER`
--

INSERT INTO `CLIENT_ORDER` (`userId`, `orderTime`, `notes`) VALUES
(1, '2025-02-10', 'Please deliver on weekend only'),
(4, '2025-02-15', 'Call before delivery, need to remove old furniture'),
(5, '2025-03-01', 'Elevator access available, 3rd floor'),
(1, '2025-03-15', 'Assembly service requested');

--
-- Dumping data for table `ORDER_HAS_ARTICLE`
--

INSERT INTO `ORDER_HAS_ARTICLE` (`orderId`, `articleId`, `versionId`, `count`) VALUES
(1, 1, 1, 1),
(1, 2, 1, 1),
(2, 4, 1, 1),
(2, 5, 1, 1),
(3, 6, 1, 1),
(3, 7, 1, 6),
(4, 8, 1, 1),
(4, 9, 1, 1);

--
-- Dumping data for table `DELIVERY`
--

INSERT INTO `DELIVERY` (`orderId`, `departureTime`, `arrivalTime`, `lastPosition`) VALUES
(1, '2025-02-12 12:00:00', '2025-02-14 15:00:00', 'Delivered'),
(2, '2025-02-17 09:00:00', '2025-02-20 16:00:00', 'Delivered'),
(3, '2025-03-03 13:00:00', NULL, 'In Warehouse'),
(4, '2025-03-17 07:00:00', NULL, 'Processing');

--
-- Dumping data for table `NOTIFICATION`
--

INSERT INTO `NOTIFICATION` (`userId`, `receptionTime`, `content`, `isRead`) VALUES
(1, '2026-02-12 11:00:00', 'Login effettuato', false);
