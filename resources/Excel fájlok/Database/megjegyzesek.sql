drop table megjegyzes;

create table megjegyzes(id int(5) auto_increment primary key,neptunkod varchar(100),megjegyzes varchar(5000),created_at timestamp,updated_at timestamp);

select * from megjegyzes;
select * from valaszok;

select  distinct v.tantargy_id,t.nev,v.szak_id from valaszok v,tantargy t where t.id=v.tantargy_id and  v.neptunkod = 'jppi9c';
