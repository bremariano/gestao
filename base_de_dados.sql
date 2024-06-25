create table categoria
(
    id      int auto_increment
        primary key,
    title   varchar(255)  not null,
    content text          not null,
    status  int default 0 not null
);

create table posts
(
    id           int auto_increment
        primary key,
    categoria_id bigint        not null,
    titulo       varchar(255)  not null,
    texto        text null,
    status       int default 1 not null
);

create table usuarios
(
    id            int auto_increment
        primary key,
    level         int      default 1                   not null,
    nome          varchar(255)                         not null,
    email         varchar(255)                         not null,
    senha         varchar(255)                         not null,
    status        int      default 0                   not null,
    ultimo_login  datetime null,
    cadastrado_em datetime default current_timestamp() not null,
    atualizado_em datetime null,
    constraint email
        unique (email)
);