drop table if exists appunti.utenti cascade;
drop table if exists appunti.corsi cascade;
drop table if exists appunti.lezioni cascade;
drop table if exists appunti.note cascade;
drop table if exists appunti.views cascade;

create table appunti.utenti ( 
	nickname text not null, 
	password text not null, 
	primary key(nickname)
);

create table appunti.corsi ( 
	titolo text not null, 
	professore text not null, 
	stamp timestamp not null default current_timestamp,
	primary key(titolo),
    creatore text references appunti.utenti(nickname) on delete cascade
);

create table appunti.lezioni ( 
	titolo text not null, 
	ora real not null default 12 check(ora<24.00 AND ora > -1.0), 
	giorno integer not null default 31 check(giorno>0 AND giorno <32), 
	mese integer not null default 12 check(mese<13 AND mese>0), 
	anno integer not null default 2018 check(anno>1970), 
	stamp timestamp not null default current_timestamp,
	primary key(titolo),
	corso text references appunti.corsi(titolo) on delete cascade,
	creatore text references appunti.utenti(nickname) on delete cascade
);

create table appunti.note ( 
	id serial not null, 
	titolo text not null, 
	testo text not null, 
	primary key(id),
	lezione text references appunti.lezioni(titolo) on delete cascade,
	creatore text references appunti.utenti(nickname) on delete cascade,
	stamp timestamp not null default current_timestamp,
	views integer default 0
);

create table appunti.views ( 
	id serial not null,
	nota integer not null references appunti.note(id) on delete cascade, 
	stamp timestamp not null default current_timestamp,
	primary key(id),
    utente text not null references appunti.utenti(nickname) on delete cascade
);

create or replace function appunti.nuovo_utente(nick text, pwd text) returns void as $$
  insert into appunti.utenti (nickname, password) values (nick, md5(pwd));
$$ language sql;

create or replace function appunti.credenziali_valide(n text, p text) returns boolean as $$
declare
  pwd text;
begin
  select password into pwd from appunti.utenti where nickname=n;
  if md5(p) = pwd
     then return true;
     else return false;
  end if;
end;
$$ language plpgsql;

create or replace function appunti.corsi() returns SETOF appunti.corsi as $$
  select * from appunti.corsi;
$$ language sql;

create or replace function appunti.cerca_corsi(nome text) returns SETOF appunti.corsi as $$
	select * from appunti.corsi where appunti.corsi.titolo ilike '%' || nome || '%';
$$ language sql;

create or replace function appunti.cerca_lezioni(nome text) returns SETOF appunti.lezioni as $$
	select * from appunti.lezioni where appunti.lezioni.titolo ilike '%' || nome || '%';
$$ language sql;

create or replace function appunti.cerca_note(nome text) returns SETOF appunti.note as $$
	select * from appunti.note where appunti.note.titolo ilike '%' || nome || '%';
$$ language sql;

create or replace function appunti.aggiungi_corso(titolo text, professore text, creatore text) returns void as $$
	insert into appunti.corsi (titolo,professore,creatore) values (titolo,professore,creatore);
$$ language sql;

create or replace function appunti.aggiungi_lezione(titolo text, ora real, giorno integer, mese integer, anno integer, corso text,creatore text) returns void as $$
	insert into appunti.lezioni (titolo, ora, giorno, mese, anno, corso,creatore) values (titolo, ora, giorno, mese, anno, corso,creatore);
$$ language sql;

create or replace function appunti.aggiungi_nota(titolo text, testo text, lezione text,creatore text) returns void as $$
	insert into appunti.note (titolo, testo,lezione,creatore) values (titolo, testo,lezione,creatore);
$$ language sql;

create or replace function appunti.incrementa_views(nickname text, id integer) returns void as $$
	insert into appunti.views (utente,nota) values (nickname,id);
$$ language sql;

create or replace function appunti.views_f() returns trigger as $$
declare
  idnota integer = new.nota;
begin
	update note set views = views + 1 where id = idnota;
  	return new;
end
$$ language plpgsql;

drop trigger if exists views_f on appunti.views;
create trigger views_f after insert on appunti.views
  for each row execute procedure appunti.views_f();

select appunti.nuovo_utente('pippo', 'yuk!');
select appunti.nuovo_utente('pluto', 'arfbau');
select appunti.nuovo_utente('minnie', 'ciao!');
select appunti.nuovo_utente('dd', 'dd');
select appunti.nuovo_utente('nn', 'nn');

select appunti.aggiungi_corso('asd1','raffaeta','dd');
select appunti.aggiungi_corso('calcolo1','sartoretto','nn');
select appunti.aggiungi_corso('asd2','pelillo','dd');
select appunti.aggiungi_corso('ada','gaetan','dd');

select appunti.aggiungi_corso('bd1','raffaeta','dd');
select appunti.aggiungi_corso('calcolo2','sartoretto','nn');
select appunti.aggiungi_corso('bd2','quattrociocchi','dd');
select appunti.aggiungi_corso('sob','focardi','dd');

select appunti.aggiungi_corso('soa','balsamo','dd');
select appunti.aggiungi_corso('reti e calcolatori','balsamo','nn');
select appunti.aggiungi_corso('linguaggi per la rete','albarelli','dd');
select appunti.aggiungi_corso('matematica discreta','salibra','dd');

select appunti.aggiungi_corso('po1','albarelli','dd');
select appunti.aggiungi_corso('po2','spano','nn');
select appunti.aggiungi_corso('programmazione 1','rossi','dd');
select appunti.aggiungi_corso('programmazione 2','marin','dd');

select appunti.aggiungi_lezione('btrees','12.00','12','12','2012','asd2','dd');
select appunti.aggiungi_lezione('alberi di van emde boas','12.00','12','12','2012','asd2','nn');
select appunti.aggiungi_lezione('bst','12.00','12','12','2012','asd1','dd');
select appunti.aggiungi_lezione('ciclo hamiltoniano','12.00','12','12','2012','asd2','dd');

select appunti.aggiungi_lezione('chiusura transitiva','12.00','12','12','2012','asd2','dd');
select appunti.aggiungi_lezione('vettore dei padri','12.00','12','12','2012','asd1','nn');
select appunti.aggiungi_lezione('generics','12.00','12','12','2012','po2','dd');
select appunti.aggiungi_lezione('hanoi','12.00','12','12','2012','programmazione 1','dd');

select appunti.aggiungi_nota('btrees parte 1','si diceva che crescessero solo in boschi di grafi','btrees','dd');
select appunti.aggiungi_nota('btrees parte 2','non so cosa siano','chiusura transitiva','dd');
select appunti.aggiungi_nota('chiusura transitiva-berny','si ha un arco anche dove cè un cammino','chiusura transitiva','dd');
select appunti.aggiungi_nota('btrees parte 2','non so cosa siano','btrees','dd');






