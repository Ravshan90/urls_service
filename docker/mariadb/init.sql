CREATE DATABASE IF NOT EXISTS urlsdb;
USE urlsdb;
CREATE TABLE IF NOT EXISTS urls
(
    id             int auto_increment,
    url            varchar(255) not null,
    content_length int,
    created_at     DATETIME  default current_timestamp,
    primary key (id)
);


