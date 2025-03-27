-- Database Section
-- ________________ 

create database IF NOT EXISTS test;
use test;


-- Tables Section
-- _____________ 

create table ARTICLE (
     articleId char(16) not null,
     categoryId char(16) not null,
     name char(32) not null,
     description char(128),
     material char(16) not null,
     weight int,
     size char(16),
     primary key (articleId),
     constraint FK_ArticleCategory foreign key (categoryId) references CATEGORY(categoryId)
);

create table ARTICLE_VERSION (
     versionId char(16) not null,
     features char(128) not null,
     price int not null,
     availability int not null,
     primary key (versionId),
     constraint FK_Article foreign key (articleId) references ARTICLE(articleId)
);

create table CATEGORY (
     categoryId char(16) not null,
     name char(16) not null,
     primary key (categoryId)
);

create table CUSTOMER (
     email char(32) not null,
     password char(16) not null,
     phoneNumber bigint,
     primary key (email),
     name char(16) not null,
     surname char(16) not null,
     birthDate date not null,
     primary key (email),
     constraint FK_CustomerAddress foreign key (address, civicNumber, postalCode) references ADDRESS(address, civicNumber, postalCode),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references PAYMENT_METHOD(paymentMethodId)
);

create table ADDRESS (
     address char(32) not null,
     civicNumber int not null,
     city char(32) not null,
     postalCode int not null,
     primary key (address, civicNumber, postalCode)
);

create table PAYMENT_METHOD (
     paymentMethodId char(16) not null,
     name char(16) not null,
     primary key (paymentMethodId)
);

create table ORDER (
     orderId char(16) not null,
     email char(32) not null,
     orderDate date not null,
     status enum('Preso in carico','In consegna','Completato','Annullato') not null,
     notes char(128),
     tracking boolean not null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (email) references CUSTOMER(email) 
);

create table ORDER_HAS_ARTICLE (
     orderId char(16) not null,
     articleId char(16) not null,
     count int not null,
     constraint FK_PresentArticle foreign key (articleId) references ARTICLE(articleId),
     constraint FK_PresentOrder foreign key (orderId) references order(orderId)
);

create table DELIVERY (
     deliveyId char(16) not null,
     orderId char(16) not null,
     departure date not null,
     arrival date,
     lastPosition char(16),
     primary key (deliveyId),
     constraint FK_DeliveryOrder foreign key (orderId) references ORDER(orderId)
);

create table SELLER (
     email char(32) not null,
     password char(16) not null,
     phoneNumber bigint,
     primary key (email),
     name char(32) not null,
     deliveredOrders int not null,
     primary key (email),
     constraint FK_SellerAddress foreign key (address, civicNumber, postalCode) references ADDRESS(address, civicNumber, postalCode)
);


-- Constraints Section
-- ___________________ 


-- Index Section
-- _____________ 

