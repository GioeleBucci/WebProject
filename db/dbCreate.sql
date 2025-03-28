create schema if not exists test;
use test;

create table if not exists test.CATEGORY (
     categoryId int not null AUTO_INCREMENT,
     name char(16) null,
     primary key (categoryId)
)
engine = InnoDB;

create table if not exists test.ARTICLE (
     articleId int not null AUTO_INCREMENT,
     name char(32) null,
     description char(128) null,
     material char(16) null,
     weight int null,
     size char(16) null,
     categoryId int not null,
     primary key (articleId),
     constraint FK_ArticleCategory foreign key (categoryId) references test.CATEGORY(categoryId)
)
engine = InnoDB;

create table if not exists test.ARTICLE_VERSION (
     versionId int not null AUTO_INCREMENT,
     articleId int not null,
     features char(128) null,
     price int null,
     availability int null,
     primary key (versionId),
     constraint FK_Article foreign key (articleId) references test.ARTICLE(articleId)
)
engine = InnoDB;

create table if not exists test.PAYMENT_METHOD (
     paymentMethodId int not null AUTO_INCREMENT,
     name char(16) null,
     primary key (paymentMethodId)
)
engine = InnoDB;

create table if not exists test.USER (
     email char(32) not null,
     password char(16) null,
     isSeller boolean null,
     address char(64) null,
     phoneNumber char(16) null,
     name char(32) null, 
     birthDate date null,
     primary key (email)
)
engine = InnoDB;

create table if not exists test.CUSTOMER (
     email char(32) not null,
     paymentMethodId int not null,
     primary key (email),
     constraint FK_CustomerKey foreign key (email) references test.USER(email),
     constraint FK_CustomerPaymentMethod foreign key (paymentMethodId) references test.PAYMENT_METHOD(paymentMethodId)  
)
engine = InnoDB;


create table if not exists test.ORDER (
     orderId int not null AUTO_INCREMENT,
     email char(32) not null,
     orderDate date null,
     notes char(128) null,
     primary key (orderId),
     constraint FK_OrderIssuer foreign key (email) references test.CUSTOMER(email) 
)
engine = InnoDB;

create table if not exists test.ORDER_HAS_ARTICLE (
     orderId int not null,
     articleId int not null,
     count int null,
     primary key (orderId, articleId),
     constraint FK_PresentArticle foreign key (articleId) references test.ARTICLE(articleId),
     constraint FK_PresentOrder foreign key (orderId) references test.ORDER(orderId)
)
engine = InnoDB;

create table if not exists test.DELIVERY (
     deliveyId int not null AUTO_INCREMENT,
     orderId int not null,
     departure date null,
     arrival date null,
     lastPosition char(16) null,
     primary key (deliveyId),
     constraint FK_Order foreign key (orderId) references test.ORDER(orderId)
)
engine = InnoDB;

create table if not exists test.SELLER (
     email char(32) not null,
     deliveredOrders int null,
     primary key (email),
     constraint FK_SellerKey foreign key (email) references test.USER(email)
)
engine = InnoDB;

