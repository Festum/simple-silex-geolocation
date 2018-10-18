use test;

create table ipinfo(
	ip varchar(15) not null primary key,
	city varchar(60),
	country char(2)
);
insert into ipinfo values ('127.0.0.1', 'Home', 'NN');
