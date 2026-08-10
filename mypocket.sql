create database mypocket;

use mypocket;

create table transacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor INT NOT NULL,
    descricao VARCHAR(100) NOT NULL
)