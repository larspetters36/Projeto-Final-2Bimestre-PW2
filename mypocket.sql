create database mypocket;

use mypocket;

create table transacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL
    valor DECIMAL(10,2) NOT NULL,
    descricao VARCHAR(300) NOT NULL
    data DEFAULT CURRENT_TIMESTAMP
)