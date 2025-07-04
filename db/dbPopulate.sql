use kiwi;

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
('LEPNA', 'Outdoor table with 2 chairs', 'Aluminum', 15.50, 79, '100x100 cm', 5, 'tableOutdoor.png', 'A durable outdoor table set with two aluminum chairs, perfect for enjoying meals in your garden or patio. Its weather-resistant materials ensure long-lasting use in any outdoor setting.'),
('VEDVÅ', 'Kitchen cabinet with doors and drawer', 'Wood', 50.00, 249, '120x80x90 cm', 6, 'cabinet.png', 'This kitchen unit make it easy to create a practical kitchen catered to your very needs. Can also be fitted with a sink and faucet.'),
('HELIMVI', 'Stainless steel range hood', 'Stainless Steel', 20.00, 199, '90x50x30 cm', 6, 'rangeHood.png', 'A sleek stainless steel range hood with powerful ventilation, ideal for keeping your kitchen fresh and odor-free.'),
('LEJLIN', 'Shower enclosure with sliding doors', 'Glass/Aluminum', 70.00, 499, '120x80x200 cm', 7, 'shower.png', 'A modern shower enclosure with tempered glass and smooth sliding doors, perfect for any bathroom renovation.'),
('UBTUSFAM', 'Bathroom vanity with sink', 'Wood/Stainless Steel', 40.00, 299, '80x50x85 cm', 7, 'sink.png', 'A stylish bathroom vanity with a stainless steel sink and wooden cabinet, functional and elegant.');

INSERT INTO `ARTICLE_VERSION` (`articleId`, `versionId`, `versionType`, `priceVariation`, `stockAmount`) VALUES
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
(10, 1, 'Natural Finish', 0, 2),
(11, 1, 'Natural Finish', 0, 2),
(12, 1, 'Natural Finish', 0, 2),
(13, 1, 'Natural Finish', 0, 2),
(14, 1, 'Natural Finish', 0, 2);

--
-- Dumping data for table `PAYMENT_METHOD`
--

INSERT INTO `PAYMENT_METHOD` (`name`) VALUES
('Credit Card'),
('PayPal'),
('Bank Transfer');

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`email`, `password`, `salt`, `address`, `phoneNumber`, `name`, `birthDate`) VALUES
('user@example.com', '81f0a8e056a394c8a3f17e24b5d6f49e5815adf34f1696abf797cd65c5877550f8abee9114d5d0b6146cfaf1952fd2449f603a5237b60f3de67529661993a08c', '031ea52dc4385b1cac7d71ca5d7eb9b3aa89878ba3b0007e42d2db3194215e7bcc2f957ff6ec10294a718059127d5f00588425396af2379e3eb91db330c2001d', '123 Oak St, Furnitureville, US', '555-123-4567', 'Emma Johnson', '1985-05-15'),
('seller1@shop.com', 'b634ad73c79fc4a9c62663ffce8ef0343afddc976f5ae73cc56b448048da399bca795ab73b2659c2fa09eca1913a0051da64c4c66d276ffc75c3b7338ce64f1a', '50190b4da37db7fa0d44db7794efca819367d88cff6b2e4f11a2e419bb413ee3cb73188637ea9747ab15dc0ff87a3c77492a29a3f59a91e0852a00a52fce9031', '200 Retail Blvd, Shopville, US', '555-333-4444', 'Home Elegance', '1982-07-17'),
('seller2@shop.com', 'f7e4351b04ff67430cac0cd4e6c2e67514bc056515f5649f318005762b1e84c039c0d74607edf3d990f5932dc829d72f24ac9c20a6606eb47c006b15cd820b82', '21b6aad10d75e637808b1585a26bd485eb57ce63208b5f9ba4d558cad12220f367aeadcf70808eeecd19aebaede9a477abfff8d524e6df3e74b2dba12b3d42f2', '100 Commerce Way, Market City, US', '555-111-2222', 'Lux Furniture', '1975-01-10'),
('user2@example.com', 'c0e4df94e180fc4a208fb0c6d53c017f2efc81fe5c6dd3c3a2fe98b7598ac74ac08d2da576adc2e670326994366722c01b70b59f567b0cfcab535e26c3c02cb3', '972b0d157ce67b03e8cf75e18f4504195867faddfd4315c8f9d72046b40fd050f7a294b3d5632c414a95b7853069eddd51c58c348ba68169876bec30929da5d1', '456 Maple Ave, Hometown, US', '555-987-6543', 'Michael Brown', '1978-11-22'),
('user3@example.com', '4590e937c120d49f82bad90fa0db7a485c5b2b3c5ed67616cdd159afbf284cb24665527cd7efa30cd367f1afb585c8b403e36e0d55ce75148ed86350e7f8dd96', 'ac1a69a3cf4f653eca42f4761ae1f4a23403b39ad5bc5d7fc24b41366b88c27ae059e69e864535dfa0dbf63a296414dc151612a4d28f071202794bb48c78c646', '789 Pine Rd, Decor City, US', '555-555-1212', 'Olivia Smith', '1990-08-30');

--
-- Dumping data for table `SELLER`
--

INSERT INTO `SELLER` (`userId`, `deliveredOrders`) VALUES
(2, 178),
(3, 205);

--
-- Dumping data for table `LISTING`
--

INSERT INTO `LISTING` (`articleId`, `sellerId`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3);

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

-- INSERT INTO `CLIENT_ORDER` (`userId`, `orderTime`, `notes`) VALUES
-- (1, '2025-02-10', 'Please deliver on weekend only'),
-- (4, '2025-02-15', 'Call before delivery, need to remove old furniture'),
-- (5, '2025-03-01', 'Elevator access available, 3rd floor'),
-- (1, '2025-03-15', 'Assembly service requested');

--
-- Dumping data for table `ORDER_HAS_ARTICLE`
--

-- INSERT INTO `ORDER_HAS_ARTICLE` (`orderId`, `articleId`, `versionId`, `amount`) VALUES
-- (1, 1, 1, 1),
-- (1, 2, 1, 1),
-- (2, 4, 1, 1),
-- (2, 5, 1, 1),
-- (3, 6, 1, 1),
-- (3, 7, 1, 6),
-- (4, 8, 1, 1),
-- (4, 9, 1, 1);

--
-- Dumping data for table `DELIVERY`
--

-- INSERT INTO `DELIVERY` (`orderId`, `departureTime`, `arrivalTime`, `lastPosition`) VALUES
-- (1, '2025-02-12 12:00:00', '2025-02-14 15:00:00', 'Delivered'),
-- (2, '2025-02-17 09:00:00', '2025-02-20 16:00:00', 'Delivered'),
-- (3, '2025-03-03 13:00:00', NULL, 'In Warehouse'),
-- (4, '2025-03-17 07:00:00', NULL, 'Processing');

--
-- Dumping data for table `SHOPPING_CART_ITEM`
--

-- INSERT INTO `SHOPPING_CART_ITEM` (`userId`, `articleId`, `versionId`, `amount`) VALUES
-- (1, 1, 1, 1),
-- (1, 2, 1, 1),
-- (1, 3, 1, 1);
