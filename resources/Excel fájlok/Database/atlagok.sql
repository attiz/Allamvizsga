select avg(v.valasz),ta.nev,t.nev,v.szak_id  from valaszok v,tantargy t,tanar_tantargy tt, tanar ta where v.tantargy_id = t.id 
and tt.tantargy_id = t.id and tt.tanar_id = ta.id group by v.tantargy_id,v.szak_id; 

select avg(v.valasz),v.kerdes_id,tt.tanar_id,v.szak_id  from valaszok v,tantargy t,tanar_tantargy tt where v.tantargy_id = t.id 
and tt.tantargy_id = t.id and tt.tanar_id= 128 and v.szak_id = 73 group by v.kerdes_id;

select tt.tanar_id,v.szak_id,avg(v.valasz) as atlag  from valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id and tt.tanar_id= 128 and v.szak_id = 73 group by v.szak_id;
select (count(distinct neptunkod)) from valaszok where szak_id = 73; 

select v.kerdoiv_id,v.kerdes_id,tt.tanar_id,v.szak_id,v.valasz from valaszok v,tantargy t,tanar_tantargy tt 
            where v.tantargy_id = t.id and tt.tantargy_id = t.id order by v.kerdoiv_id;
            
select tanar_id,valaszok.szak_id,avg(valasz) from valaszok,tanar_tantargy where tanar_tantargy.tantargy_id = valaszok.tantargy_id group by szak_id,tanar_id;            

select * from valaszok;           
