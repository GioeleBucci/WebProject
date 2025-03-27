-- Database Section
-- ________________ 

create database IF NOT EXISTS test;
use test;


-- Tables Section
-- _____________ 

create table CATEGORY (
     categoryId int not null AUTO_INCREMENT,
     name char(16) null,
     primary key (categoryId)
);

create table ARTICLE (
     articleId int not null AUTO_INCREMENT,
     name char(32) null,
     description char(128) null,
     material char(16) null,
     weight int null,
     size char(16) null,
     categoryId int not null,
     primary key (articleId),
     constraint FK_ArticleCategory foreign key (categoryId)
     references CATEGORY(categoryId)
);

create table ARTICLE_VERSION (
     versionId int not null AUTO_INCREMENT,
     articleId int not null,
     features char(128) null,
     price int null,
     availability int null,
     primary key (versionId),
     constraint FK_Article foreign key (articleId) references ARTICLE(articleId)
);

create table PAYMENT_METHOD (
     paymentMethodId int not null AUTO_INCREMENT,
     name char(16) null,
     primary key (paymentMethodId)
);

create table CUSTOMER (
     email char(32) not null,
     password char(16) null,
     address char(64) null,
     phoneNumber char(16) null,
     name char(16) null,
     surname char(16) null,
     birthDate date null,
     paymentMethodId int not null,
     primary key (email),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references PAYMENT_METHOD(paymentMethodId)
);

create table ORDERS (
     orderId int not null AUTO_INCREMENT,
     email char(32) not null,
     orderDate date null,
     notes char(128) null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (email) references CUSTOMER(email) 
);

create table ORDER_HAS_ARTICLE (
     orderId int not null,
     articleId int not null,
     count int null,
     constraint FK_PresentArticle foreign key (articleId) references ARTICLE(articleId),
     constraint FK_PresentOrder foreign key (orderId) references ORDERS(orderId)
);

create table DELIVERY (
     deliveyId int not null AUTO_INCREMENT,
     orderId int not null,
     departure date null,
     arrival date null,
     lastPosition char(16) null,
     primary key (deliveyId),
     constraint FK_Order foreign key (orderId) references ORDERS(orderId)
);

create table SELLER (
     email char(32) not null,
     password char(16) null,
     address char(64) null,
     phoneNumber char(16) null,
     name char(32) null,
     deliveredOrders int null,
     primary key (email)
);


-- Constraints Section
-- ___________________ 


-- Index Section
-- _____________ 

