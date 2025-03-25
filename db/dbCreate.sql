-- Database Section
-- ________________ 

create database TEST;
use TEST;


-- Tables Section
-- _____________ 

create table ARTICLE (
     articleId char(16) not null,
     name char(32) not null,
     description char(128),
     material char(16) not null,
     weight int,
     size char(16),
     constraint IDARTICOLO primary key (articleId));

create table CATEGORY (
     categoryId char(16) not null,
     name char(16) not null,
     constraint IDCATEGORIA primary key (categoryId));

create table CUSTOMER (
     name char(16) not null,
     surname char(16) not null,
     birthDate date not null);

create table ADDRESS (
     address char(32) not null,
     civicNumber int not null,
     city char(32) not null,
     postalCode int not null,
     constraint IDINDIRIZZO primary key (address, civicNumber, postalCode));

create table PAYMENT_METHOD (
     paymentMethodId char(16) not null,
     name char(16) not null,
     constraint IDMETODO_PAGAMENTO primary key (paymentMethodId));

create table ORDER (
     orderId char(16) not null,
     orderDate date not null,
     status char(1) not null,
     notes char(128),
     tracking char not null,
     refunded char not null,
     constraint IDORDINE primary key (orderId));

create table DELIVERY (
     deliveyId char(16) not null,
     departure date not null,
     arrival date,
     lastPosition char(16),
     constraint IDSPEDIZIONE primary key (deliveyId));

create table USER (
     email varchar(32) not null,
     password varchar(16) not null,
     phoneNumber bigint,
     constraint IDUTENTE primary key (email));

create table SELLER (
     name char(32) not null,
     deliveredOrders int not null);

create table ARTICLE_VERSION (
     versionId char(16) not null,
     features char(128) not null,
     price int not null,
     availability int not null,
     constraint IDVERSIONE_ARTICOLO primary key (, ));


-- Constraints Section
-- ___________________ 


-- Index Section
-- _____________ 

