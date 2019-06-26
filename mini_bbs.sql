create table wonder_members
(
    id text,
    year text,
    school_num text,
    name text,
    email text,
    password text,
    skill text,
    picture text
);

create table wonder_posts
(
    id text,
    member_id text,
    title text,
    content text
);

create table wonder_teams
(
    id text,
    member_id text,
    content_id text
);

create table wonder_goods
(
    id text,
    member_id text,
    content_id text
)

create table wonder_chats
(
    id serial primary key,
    message text,
    member_id text,
    content_id text,
    created TIMESTAMP
);

create table wonder_questions
(
    id serial primary key,
    title text,
    message text,
    member_id text,
    created TIMESTAMP
);

create table wonder_awnsers
(
    id serial primary key,
    message text,
    member_id text,
    question_id int,
    created TIMESTAMP
);