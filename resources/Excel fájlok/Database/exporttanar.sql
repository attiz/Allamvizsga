drop table tanar;
create table tanar(id int(5) auto_increment primary key,nev varchar(100),felhasznalo varchar(50) unique,jelszo varchar(200),tanszek int(5) references tanszek(id), fokozat int(5) references fokozat(id),email varchar(100), statusz int(1) default 1,funkcio int(1) default 1,created_at timestamp,updated_at timestamp);
insert into tanar(nev,felhasznalo,jelszo,statusz) values ('Zöld Attila','zolda','zold',2);
select * from tanar where felhasznalo like 'admin%';
select * from tanar where nev like 'bako%';
select * from tanar where id = 69;

update tanar set statusz = 2 where felhasznalo like 'admin%';
update tanar set funkcio = 2 where felhasznalo like 'domokos';
update tanar set funkcio = 3 where felhasznalo like 'dvid3757';
DELETE FROM tanar WHERE felhasznalo != 'zold169';

SELECT tanar.*,tanszek.nev as tansz
FROM tanar
left outer JOIN tanszek ON tanar.tanszek = tanszek.id;

select * from tanar;
select count(*) from tanar;