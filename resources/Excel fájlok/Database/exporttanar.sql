drop table tanar;
create table tanar(id int(5) auto_increment primary key,nev varchar(100),felhasznalo varchar(50) unique,jelszo varchar(50),tanszek varchar(100), fokozat varchar(50),email varchar(100), statusz int(1) default 1,funkcio int(1) default 1,created_at timestamp,updated_at timestamp);

select * from tanar;
select count(*) from tanar;

update tanar set statusz = 2 where felhasznalo like 'zold734';
DELETE FROM tanar WHERE felhasznalo != 'zold288';