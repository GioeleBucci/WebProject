create schema if not exists test;
use test;

create table if not exists CATEGORY (
     categoryId int not null AUTO_INCREMENT,
     name char(31) null,
     primary key (categoryId)
);

create table if not exists ARTICLE (
     articleId int not null AUTO_INCREMENT,
     name char(31) null,
     details text null,
     longDescription text null,
     material char(63) null,
     weight decimal(6,2) null,
     basePrice decimal(6,2) null,
     size char(31) null,
     categoryId int not null,
     image char(255) null,
     primary key (articleId),
     constraint FK_ArticleCategory foreign key (categoryId) references CATEGORY(categoryId)
);

create table if not exists ARTICLE_VERSION (
     articleId int not null,
     versionId int not null,
     versionType char(63) null,
     priceVariation decimal(6,2) default 0,
     stockAmount int default 0,
     primary key (articleId, versionId),
     constraint FK_Article foreign key (articleId) references ARTICLE(articleId)
);

create table if not exists PAYMENT_METHOD (
     paymentMethodId int not null AUTO_INCREMENT,
     name char(31) null,
     primary key (paymentMethodId)
);

create table if not exists USER (
     userId int not null AUTO_INCREMENT,
     email char(63) not null UNIQUE,
     password char(31) null,
     address char(255) null,
     phoneNumber char(31) null,
     name char(31) null, 
     birthDate date null,
     primary key (userId)
);

create table if not exists SELLER (
     userId int not null,
     deliveredOrders int null,
     primary key (userId),
     constraint FK_SellerKey foreign key (userId) references USER(userId)
);

create table if not exists LISTING (
     articleId int not null,
     sellerId int not null,
     primary key (articleId),
     constraint FK_ArticleId foreign key (articleId) references ARTICLE(articleId)
);

create table if not exists CLIENT (
     userId int not null,
     paymentMethodId int not null,
     primary key (userId),
     constraint FK_CustomerKey foreign key (userId) references USER(userId),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references PAYMENT_METHOD(paymentMethodId)  
);

create table if not exists CLIENT_ORDER (
     orderId int not null AUTO_INCREMENT,
     userId int not null,
     orderTime datetime null,
     notes char(127) null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (userId) references CLIENT(userId) 
);

create table if not exists ORDER_HAS_ARTICLE (
     orderId int not null,
     articleId int not null,
     versionId int not null,
     amount int null,
     primary key (orderId, articleId, versionId),
     constraint FK_Order foreign key (orderId) references CLIENT_ORDER(orderId),
     constraint FK_SelectedArticle foreign key (articleId, versionId) references ARTICLE_VERSION(articleId, versionId)
);

create table if not exists SHOPPING_CART_ITEM (
     userId int not null,
     articleId int not null,
     versionId int not null,
     amount int null,
     primary key (userId, articleId, versionId),
     constraint FK_CartOwner foreign key (userId) references CLIENT(userId),
     constraint FK_ListedArticle foreign key (articleId, versionId) references ARTICLE_VERSION(articleId, versionId)
);

create table if not exists DELIVERY (
     deliveyId int not null AUTO_INCREMENT,
     orderId int not null,
     departureTime datetime null,
     arrivalTime datetime null,
     lastPosition char(255) null,
     primary key (deliveyId),
     constraint FK_DeliveryOrder foreign key (orderId) references CLIENT_ORDER(orderId)
);

create table if not exists NOTIFICATION (
     notificationId int not null AUTO_INCREMENT,
     userId int not null,
     receptionTime datetime null,
     content text null,
     isRead boolean default false,
     primary key (notificationId),
     constraint FK_NotifiedUser foreign key (userId) references USER(userId)
);

create table if not exists WISHLIST (
     userId int not null,
     articleId int not null,
     primary key (userId, articleId),
     constraint FK_WishlistOwner foreign key (userId) references USER(userId),
     constraint FK_WishlistArticle foreign key (articleId) references ARTICLE(articleId)
);

