--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`email`, `password`, `isSeller`, `address`, `phoneNumber`, `name`, `birthDate`) VALUES
('emma@example.com', 'password', 0, '123 Oak St, Furnitureville, US', '555-123-4567', 'Emma Johnson', '1985-05-15'),
('seller1@shop.com', 'password', 1, '200 Retail Blvd, Shopville, US', '555-333-4444', 'Home Elegance', '1982-07-17'),
('seller2@shop.com', 'password', 1, '100 Commerce Way, Market City, US', '555-111-2222', 'Lux Furniture', '1975-01-10'),
('michael@example.com', 'password', 0, '456 Maple Ave, Hometown, US', '555-987-6543', 'Michael Brown', '1978-11-22'),
('olivia@example.com', 'password', 0, '789 Pine Rd, Decor City, US', '555-555-1212', 'Olivia Smith', '1990-08-30');

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`categoryId`, `name`) VALUES
(1, 'Living Room'),
(2, 'Bedroom'),
(3, 'Dining Room'),
(4, 'Office'),
(5, 'Outdoor'),
(6, 'Kitchen'),
(7, 'Bathroom');

--
-- Dumping data for table `ARTICLE`
--

INSERT INTO `ARTICLE` (`articleId`, `name`, `description`, `material`, `weight`, `basePrice`, `size`, `categoryId`, `image`) VALUES
(1, 'FUKREJIV', '3-seater sofa', 'Fabric', 85.00, 499, '240x160x80 cm', 1, 'sofa.png'),
(2, 'MÅEYE', 'Round glass coffee table', 'Glass/Metal', 250.00, 79, '90x90x45 cm', 1, 'coffeeTable.png'),
(3, 'KOBNE', 'Tall bookshelf with 5 shelves', 'Oak', 40.00, 199, '180x80x30 cm', 1, 'bookshelf.png'),
(4, 'LUUYFO', 'Queen size bed frame', 'Walnut', 70.00, 99.90, '160x200 cm', 2, 'bedFrame.png'),
(5, 'EDIVPÅSÖ', 'Six-drawer dresser', 'Cherry Wood', 65.00, 299, '120x50x80 cm', 2, 'drawer.png'),
(6, 'HORJÅ', 'Expandable dining table', 'Maple', 55.00, 129, '180x90x75 cm', 3, 'tableExpandable.png'),
(7, 'KEPSÖ', 'Upholstered dining chair', 'Oak/Fabric', 80.00, 49.90, '45x55x95 cm', 3, 'chair.png'),
(8, 'TÖDHIAFJI', 'Office desk with drawers', 'Mahogany', 6.00, 159, '160x80x75 cm', 4, 'desk.png'),
(9, 'PUPYIDRÅ', 'Ergonomic office chair', 'Mesh/Metal', 15.00, 109.90, '65x65x120 cm', 4, 'chairOffice.png'),
(10, 'LEPNA', 'Outdoor table with 2 chairs', 'Aluminum', 15.50, 79, '100x100 cm', 5, 'tableOutdoor.png');

--
-- Dumping data for table `ARTICLE_VERSION`
--

INSERT INTO `ARTICLE_VERSION` (`versionId`, `articleId`, `features`, `priceVariation`, `availability`) VALUES
(1, 1, 'Gray Fabric', 0, 5),
(2, 1, 'Blue Fabric', 0, 3),
(3, 1, 'Beige Fabric', 0, 7),
(4, 2, 'Clear Glass', 0, 10),
(5, 2, 'Smoked Glass', 5, 6),
(6, 3, 'Natural Finish', 0, 8),
(7, 3, 'Dark Finish', 0, 4),
(8, 4, 'Natural Finish', 0, 3),
(9, 4, 'Dark Finish', 0, 5),
(10, 5, 'White', 0, 4),
(11, 5, 'Cherry Finish', 7.90, 2),
(12, 6, 'Natural Finish', 0, 3),
(13, 6, 'Espresso Finish', 9.90, 2),
(14, 7, 'Gray Fabric', 0, 12),
(15, 7, 'Beige Fabric', 0, 8),
(16, 8, 'Natural Finish', 0, 2),
(17, 8, 'Dark Finish', 0, 3),
(18, 9, 'Black', 0, 7),
(19, 9, 'Gray', 0, 5),
(20, 10, 'Natural Finish', 0, 2);


--
-- Dumping data for table `PAYMENT_METHOD`
--

INSERT INTO `PAYMENT_METHOD` (`paymentMethodId`, `name`) VALUES
(1, 'Credit Card'),
(2, 'PayPal'),
(3, 'Cash on Delivery'),
(4, 'Bank Transfer'),
(5, 'Store Credit');


--
-- Dumping data for table `CUSTOMER`
--
INSERT INTO `CUSTOMER` (`email`, `paymentMethodId`) VALUES
('emma@example.com', 1),
('olivia@example.com', 2),
('michael@example.com', 3);

--
-- Dumping data for table `SELLER`
--

INSERT INTO `SELLER` (`email`, `deliveredOrders`) VALUES
('seller1@shop.com', 178),
('seller2@shop.com', 205);

--
-- Dumping data for table `CLIENT_ORDER`
--

INSERT INTO `CLIENT_ORDER` (`orderId`, `email`, `orderDate`, `notes`) VALUES
(1, 'emma@example.com', '2025-02-10', 'Please deliver on weekend only'),
(2, 'michael@example.com', '2025-02-15', 'Call before delivery, need to remove old furniture'),
(3, 'olivia@example.com', '2025-03-01', 'Elevator access available, 3rd floor'),
(4, 'emma@example.com', '2025-03-15', 'Assembly service requested');

--
-- Dumping data for table `DELIVERY`
--

INSERT INTO `DELIVERY` (`deliveyId`, `orderId`, `departure`, `arrival`, `lastPosition`) VALUES
(1, 1, '2025-02-12', '2025-02-14', 'Delivered'),
(2, 2, '2025-02-17', '2025-02-20', 'Delivered'),
(3, 3, '2025-03-03', NULL, 'In Warehouse'),
(4, 4, '2025-03-17', NULL, 'Processing');

--
-- Dumping data for table `ORDER_HAS_ARTICLE`
--

INSERT INTO `ORDER_HAS_ARTICLE` (`orderId`, `articleId`, `count`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 4, 1),
(2, 5, 1),
(3, 6, 1),
(3, 7, 6),
(4, 8, 1),
(4, 9, 1);

