create database if not exists axeta;
create user if not exists axeta@'%' identified by 'axeta';
grant all privileges on axeta.* to axeta@'%';
