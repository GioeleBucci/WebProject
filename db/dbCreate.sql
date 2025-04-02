create schema if not exists test;
use test;

create table if not exists CATEGORY (
     categoryId int not null,
     name char(31) null,
     primary key (categoryId)
);

create table if not exists ARTICLE (
     articleId int not null,
     name char(31) null,
     details text null,
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
     features char(255) null,
     priceVariation decimal(6,2) default 0,
     availability int default 0,
     primary key (articleId, versionId),
     constraint FK_Article foreign key (articleId) references ARTICLE(articleId)
);

create table if not exists PAYMENT_METHOD (
     paymentMethodId int not null,
     name char(31) null,
     primary key (paymentMethodId)
);

create table if not exists USER (
     email char(63) not null,
     password char(31) null,
     address char(255) null,
     phoneNumber char(31) null,
     name char(31) null, 
     birthDate date null,
     primary key (email)
);

create table if not exists SELLER (
     email char(63) not null,
     deliveredOrders int null,
     primary key (email),
     constraint FK_SellerKey foreign key (email) references USER(email)
);

create table if not exists CLIENT (
     email char(63) not null,
     paymentMethodId int not null,
     primary key (email),
     constraint FK_CustomerKey foreign key (email) references USER(email),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references PAYMENT_METHOD(paymentMethodId)  
);

create table if not exists CLIENT_ORDER (
     orderId int not null,
     email char(63) not null,
     orderDate date null,
     notes char(127) null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (email) references CLIENT(email) 
);

create table if not exists ORDER_HAS_ARTICLE (
     orderId int not null,
     articleId int not null,
     versionId int not null,
     count int null,
     primary key (orderId, articleId, versionId),
     constraint FK_Order foreign key (orderId) references CLIENT_ORDER(orderId),
     constraint FK_SelectedArticle foreign key (articleId, versionId) references SHOPPING_CART_ITEM(articleId, versionId)
);

create table if not exists SHOPPING_CART_ITEM (
     email char(63) not null,
     articleId int not null,
     versionId int not null,
     count int null,
     primary key (email, articleId, versionId),
     constraint FK_CartOwner foreign key (email) references CLIENT(email),
     constraint FK_ListedArticle foreign key (articleId, versionId) references ARTICLE_VERSION(articleId, versionId)
);

create table if not exists DELIVERY (
     deliveyId int not null,
     orderId int not null,
     departure date null,
     arrival date null,
     lastPosition char(255) null,
     primary key (orderId, deliveyId),
     constraint FK_DeliveryOrder foreign key (orderId) references CLIENT_ORDER(orderId)
);

create table if not exists NOTIFICATION (
     email char(63) not null,
     notificationId int not null,
     content text null,
     isRead boolean default false,
     primary key (email, notificationId),
     constraint FK_NotifiedUser foreign key (email) references USER(email)
);

