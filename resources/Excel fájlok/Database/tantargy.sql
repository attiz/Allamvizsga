drop table tantargy;

create table tantargy(id int(5) primary key auto_increment,nev varchar(200),rovidites varchar(200));

select * from tantargy where rovidites like 'Port. %';
select count(*) from tantargy;
select * from tantargy where id = 139;