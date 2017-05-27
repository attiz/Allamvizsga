drop table valaszok;
create table valaszok (id int(5) primary key auto_increment,kerdoiv_id int(5) references kerdoiv(kerdoiv_id),
kerdes_id int(5) references kerdesek(id),valasz int(1),tantargy_id int(5) references tantargyak(id),tanar_id int(5) references tanar(id),
szak_id int(5) references szak(id),tanev varchar(10),felev int(1),  created_at timestamp,updated_at timestamp);

select kerdes_id,tantargy_id, avg(valasz) from valaszok group by kerdes_id,tantargy_id;
select kerdes_id, avg(valasz) from valaszok group by kerdes_id;
select * from valaszok;

select * from valaszok where kerdes_id = 1 and tantargy_id = 867 and tanar_id = 340 and neptunkod = 'jppi9c';

select * from diak;
select * from szak;
select * from tanar_tantargy;
select * from tantargy;

select * from valaszok;
SELECT Count(*) as ossz,sum(vegleges) FROM valaszok WHERE neptunkod = 'jppi9c';
SELECT * FROM valaszok WHERE neptunkod = 'jppi9c';
select v.kerdes_id,v.tantargy_id,v.valasz,t.nev from valaszok v,tantargy t
where t.id=v.tantargy_id and  v.neptunkod = 'jppi9c';

select distinct v.kerdes_id,t.id,v.valasz,t.nev,v.szak_id  from valaszok v,tantargy t where t.id=v.tantargy_id and  v.neptunkod = 'jppi9c';
select distinct k.id,t.id,v.valasz,t.nev,v.szak_id  
from valaszok v,tantargy t,kerdesek k where t.id=v.tantargy_id 
						and k.id = v.kerdes_id
                        and  v.neptunkod ='DL7CY0' and v.kerdes_id = 1;
                        
select max(kerdoiv_id) from kerdoiv;
select ki.kerdes_id,k.kerdes,t.id,t.nev,ta.nev from kerdoiv ki,tantargy t,tanar ta,kerdesek k where ki.tanar_id = ta.id
and ki.tantargy_id = t.id
and ki.kerdes_id = k.id and
kerdoiv_id = (select distinct kerdoiv_id from valaszok where neptunkod = 'dl7cy0');        
select k.id,v.tantargy_id,v.valasz from kerdesek k right outer join valaszok v on k.id = v.kerdes_id where neptunkod = 'dl7cy0';

select ki.kerdes_id,ki.id,v.valasz from kerdoiv ki,valaszok v where d and v.kerdes_id = ki.kerdes_id
												and ki.tantargy_id = t.id and v.neptunkod = 'dl7cy0' and
                                                ki.kerdoiv_id = (select distinct kerdoiv_id from valaszok where neptunkod = 'dl7cy0');
                                                
select count(k.id),k.id from kerdesek k INNER JOIN valaszok v on v.kerdes_id = k.id group by k.id;   
select kerdes_id from valaszok where neptunkod = 'dl7cy0';        

select t1.id,t2.tantargy_id,t2.valasz
  from kerdesek t1
left join
(
  select *
  from valaszok where neptunkod = 'jppi9c' 
) t2
  on t1.id = t2.kerdes_id
  group by t1.id;
  
  select t1.id,t2.kerdes_id,t2.tantargy_id,t2.valasz  from kerdesek t1 left join
                        (select * from valaszok where neptunkod = 'dl7cy0') t2  on t1.id = t2.kerdes_id;
  
  select t1.id,t2.tantargy_id,t2.valasz  from kerdesek t1 left join
                        (select * from valaszok where tantargy_id = 867 and neptunkod = 'jppi9c') t2  on t1.id = t2.kerdes_id;