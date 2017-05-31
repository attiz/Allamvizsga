drop table tanar_tantargy;
create table tanar_tantargy(id int(5) primary key auto_increment, tanar_id int(5) references tanar(id),tantargy_id int(5) references tantargy(id),szak_id int(5) references szak(id),felev int(1),
aktiv int(1) default 1,created_at timestamp,updated_at timestamp);


select * from tanar_tantargy;
delete from tanar_tantargy where felev = 1;
select tanar_tantargy.*,tantargy.nev from tanar_tantargy,tantargy where tantargy.id = tanar_tantargy.tantargy_id and felev = 2 and szak_id = 164;
select count(*) from tanar_tantargy;
select * from tanar where id = 72;
select t.nev, ta.nev as tantargy, szak_id from tanar_tantargy tt,tanar t,tantargy ta where tt.szak_id = 73 and tt.tanar_id = t.id and tt.tantargy_id = ta.id;
select * from szak;
select name from tanar_tantargy,users where tanar_tantargy.felh_id = users.id and tanar_tantargy.tantargy_id = 4;

select * from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and tanar.id = tanar_tantargy.tanar_id and szak_id= 7;


select distinct tanar_id,tanar.nev,tantargy_id,tantargy.nev from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and tanar.id = tanar_tantargy.tanar_id and tantargy_id = 629;

select tt.*,sz.szaknev from tanar_tantargy tt,szak sz where tt.szak_id=sz.id and tt.tantargy_id = 858 and sz.szaknev like 'info%';

select * from tanar_tantargy,tanar,tantargy where tantargy.id = tanar_tantargy.tantargy_id and 
            tanar.id = tanar_tantargy.tanar_id and szak_id  = 10;
            
select distinct tanar_id,tanar.nev as tanar,tantargy_id,tantargy.nev from tanar_tantargy,tanar,tantargy,szak sz where tantargy.id = tanar_tantargy.tantargy_id and
            tanar.id = tanar_tantargy.tanar_id and tanar_tantargy.szak_id = sz.id and tantargy_id = 52 and sz.szaknev like 'info%';            