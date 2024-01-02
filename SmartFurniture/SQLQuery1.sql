create table products(
	pid int primary key identity(1,1),
	pname varchar(100),
	pprice int 
);
	select * from products
	select * from carte
	create table customers(
	email varchar(200) primary key,
	Username varchar(200),
	address varchar (200),
	password nvarchar(255),
	);
	create table carte(
	cemail varchar(200),
	productid int,
	--primary key (cemail),
	foreign key (cemail) references customers(email),
	foreign key (productid) references products(pid)
	);
	create table contact(
	name varchar(200),
	number int ,
	email varchar(100),
	message text,
	id int primary key identity(1,1)
	);
	insert into products values('product name',123);
	select * from contact
	select * from carte
    select * from products
	select * from customers
	