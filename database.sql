CREATE DATABASE IF NOT EXISTS financas_pessoais
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE financas_pessoais;
 
CREATE TABLE IF NOT EXISTS transacoes (
    id              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    descricao       VARCHAR(255)    NOT NULL,
    valor           DECIMAL(15, 2)  NOT NULL,
    tipo            ENUM('entrada', 'saida') NOT NULL,
    categoria       VARCHAR(100)    NOT NULL,
    data_transacao  DATE            NOT NULL,
    criado_em       TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_tipo (tipo),
    INDEX idx_data (data_transacao),
    INDEX idx_categoria (categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
-- Dados de exemplo
-- INSERT INTO transacoes (descricao, valor, tipo, categoria, data_transacao) VALUES
-- ('Salário mensal',       5500.00, 'entrada', 'Salário',       CURDATE()),
-- ('Aluguel apartamento',  1800.00, 'saida',   'Moradia',       CURDATE()),
-- ('Freelance design',      950.00, 'entrada', 'Freelance',     CURDATE()),
-- ('Supermercado',          420.50, 'saida',   'Alimentação',   CURDATE()),
-- ('Conta de luz',          185.00, 'saida',   'Utilidades',    CURDATE()),
-- ('Streaming serviços',     55.90, 'saida',   'Lazer',         CURDATE()),
-- ('Dividendos ações',      310.00, 'entrada', 'Investimentos', CURDATE()),
-- ('Academia',               99.90, 'saida',   'Saúde',         CURDATE());