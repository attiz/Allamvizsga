select format((valasz),2),kerdes_id from valaszok where tanar_id = 977 and szak_id = 38 and tantargy_id = 286 group by kerdes_id;
select count(distinct(kerdoiv_id)) from valaszok where tanar_id = 977 and szak_id = 38 and tantargy_id = 286;


SELECT tanar.*,tanszek.nev as tansz,fokozat.fokozat as fok FROM tanar left outer JOIN tanszek ON tanar.tanszek = tanszek.id
left outer JOIN fokozat on  tanar.fokozat = fokozat.id order by tanar.nev;

select kerdes,szaknev,format(avg(valasz),2) as atlag from valaszok,kerdesek,szak,tantargy where tanar_id = 3 and kerdesek.id = valaszok.kerdes_id
and valaszok.szak_id = szak.id and valaszok.tantargy_id = tantargy.id group by kerdes_id,szak_id;


