create schema if not exists test;
use test;

create table if not exists test.CATEGORY (
     categoryId int not null AUTO_INCREMENT,
     name char(31) null,
     primary key (categoryId)
)
engine = InnoDB;

create table if not exists test.ARTICLE (
     articleId int not null AUTO_INCREMENT,
     name char(31) null,
     description char(127) null,
     details text null,
     material char(63) null,
     weight decimal(6,2) null,
     basePrice decimal(6,2) null,
     size char(31) null,
     image char(255) null,
     categoryId int not null,
     primary key (articleId),
     constraint FK_ArticleCategory foreign key (categoryId) references test.CATEGORY(categoryId)
)
engine = InnoDB;

create table if not exists test.ARTICLE_VERSION (
     versionId int not null AUTO_INCREMENT,
     articleId int not null,
     features char(255) null,
     priceVariation decimal(6,2) default 0,
     availability int default 0,
     primary key (versionId),
     constraint FK_Article foreign key (articleId) references test.ARTICLE(articleId)
)
engine = InnoDB;

create table if not exists test.PAYMENT_METHOD (
     paymentMethodId int not null AUTO_INCREMENT,
     name char(31) null,
     primary key (paymentMethodId)
)
engine = InnoDB;

create table if not exists test.USER (
     email char(63) not null,
     password char(31) null,
     isSeller boolean default false,
     address char(255) null,
     phoneNumber char(31) null,
     name char(31) null, 
     birthDate date null,
     primary key (email)
)
engine = InnoDB;

create table if not exists test.CUSTOMER (
     email char(63) not null,
     paymentMethodId int not null,
     primary key (email),
     constraint FK_CustomerKey foreign key (email) references test.USER(email),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references test.PAYMENT_METHOD(paymentMethodId)  
)
engine = InnoDB;

create table if not exists test.CLIENT_ORDER (
     orderId int not null AUTO_INCREMENT,
     email char(63) not null,
     orderDate date null,
     notes char(127) null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (email) references test.CUSTOMER(email) 
)
engine = InnoDB;

create table if not exists test.ORDER_HAS_ARTICLE (
     orderId int not null,
     versionId int not null,
     count int null,
     primary key (orderId, versionId),
     constraint FK_PresentArticle foreign key (versionId) references test.ARTICLE_VERSION(versionId),
     constraint FK_PresentOrder foreign key (orderId) references test.CLIENT_ORDER(orderId)
)
engine = InnoDB;

create table if not exists test.DELIVERY (
     deliveyId int not null AUTO_INCREMENT,
     orderId int not null,
     departure date null,
     arrival date null,
     lastPosition char(255) null,
     primary key (deliveyId),
     constraint FK_Order foreign key (orderId) references test.CLIENT_ORDER(orderId)
)
engine = InnoDB;

create table if not exists test.SELLER (
     email char(63) not null,
     deliveredOrders int null,
     primary key (email),
     constraint FK_SellerKey foreign key (email) references test.USER(email)
)
engine = InnoDB;
