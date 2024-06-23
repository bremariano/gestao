create table categoria
(
    id      int auto_increment
        primary key,
    title   varchar(255)  not null,
    content text          not null,
    status  int default 0 not null
);

create table categoria_2
(
    id      int          null,
    title   varchar(255) null,
    content text         null,
    status  int          null
);

create table posts
(
    id           int auto_increment
        primary key,
    categoria_id bigint        not null,
    titulo       varchar(255)  not null,
    texto        text          null,
    status       int default 1 not null
);

create table posts_2
(
    id           int          null,
    categoria_id bigint       null,
    titulo       varchar(255) null,
    texto        text         null,
    status       int          null
);

