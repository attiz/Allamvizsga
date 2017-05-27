drop table kerdesek;
create table kerdesek (id int(5) primary key auto_increment,kerdes varchar(500),valasz1 varchar(500),
valasz2 varchar(500),valasz3 varchar(500),valasz4 varchar(500),valasz5 varchar(500), aktiv int(1) default 1,created_at timestamp,updated_at timestamp);


select * from kerdesek;

select * from valaszok;
select * from kerdoiv;
