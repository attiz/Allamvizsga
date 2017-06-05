drop table diak;
drop table szak;
create table diak(id int(5) primary key auto_increment, neptun varchar(15) not null,kitoltott int(1) default 0,created_at timestamp,updated_at timestamp);
create table szak(id int(5) primary key auto_increment,szaknev varchar(100));

select * from diak;
select count(*) from szak;


