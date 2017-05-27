drop table mentes;
create table mentes (id int(5) primary key auto_increment,kerdoiv_id int(5) references kerdoiv(kerdoiv_id),
kerdes_id int(5) references kerdesek(id),valasz int(1),tantargy_id int(5) references tantargyak(id),tanar_id int(5) references tanar(id),
szak_id int(5) references szak(id),neptunkod varchar(15) references diak(neptun), created_at timestamp,updated_at timestamp);

select * from mentes;