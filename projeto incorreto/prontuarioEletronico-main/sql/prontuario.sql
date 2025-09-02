DROP DATABASE IF EXISTS prontuario;

CREATE DATABASE IF NOT EXISTS prontuario;
USE prontuario;

-- Tabela de pacientes
CREATE TABLE IF NOT EXISTS paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    sexo VARCHAR(20) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(255),
    endereco TEXT,
    convenio VARCHAR(255),
    observacoes TEXT
);

-- Tabela de exames
CREATE TABLE IF NOT EXISTS exame (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT
);

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    crbm VARCHAR(50) NOT NULL
);

-- Tabela de requisições
CREATE TABLE requisicoes (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único da requisição
    numero INT NOT NULL UNIQUE,        -- Número sequencial único da requisição
    paciente_id INT NOT NULL,          -- ID do paciente relacionado
    data DATETIME NOT NULL,            -- Data da criação da requisição
    FOREIGN KEY (paciente_id) REFERENCES paciente(id)
);

-- Tabela de requisições de exames
CREATE TABLE requisicao_exames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requisicao_id INT NOT NULL,
    exame_id INT NOT NULL,
    FOREIGN KEY (requisicao_id) REFERENCES requisicoes(id) ON DELETE CASCADE,
    FOREIGN KEY (exame_id) REFERENCES exame(id) ON DELETE CASCADE
);

-- Tabela de resultados
CREATE TABLE IF NOT EXISTS resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requisicao_id INT NOT NULL, -- Relaciona o resultado à requisição
    exame_id INT NOT NULL,      -- Relaciona o resultado ao exame
    resultado TEXT NOT NULL,    -- Resultado do exame
    data DATETIME NOT NULL,     -- Data do lançamento do resultado
    FOREIGN KEY (requisicao_id) REFERENCES requisicoes(id) ON DELETE CASCADE,
    FOREIGN KEY (exame_id) REFERENCES exame(id) ON DELETE CASCADE
);

-- Inserir exames de bioquímica na tabela 'exame'
INSERT INTO exame (nome, descricao) VALUES
('Glicose', 'Exame para medir os níveis de glicose no sangue.'),
('Colesterol Total', 'Avaliação dos níveis de colesterol total no sangue.'),
('HDL (Colesterol bom)', 'Mede os níveis de colesterol HDL no sangue.'),
('LDL (Colesterol ruim)', 'Mede os níveis de colesterol LDL no sangue.'),
('Triglicerídeos', 'Avaliação dos níveis de triglicerídeos no sangue.'),
('Creatinina', 'Exame para avaliar a função renal.'),
('Ureia', 'Exame para medir os níveis de ureia no sangue.'),
('Ácido Úrico', 'Avaliação dos níveis de ácido úrico no sangue.'),
('TGO (AST)', 'Exame para avaliar a função hepática e muscular.'),
('TGP (ALT)', 'Exame para avaliar a função hepática.'),
('Fosfatase Alcalina', 'Exame para avaliar a função hepática e óssea.'),
('Gama GT', 'Exame para avaliar a função hepática e consumo de álcool.'),
('Bilirrubina Total', 'Avaliação dos níveis de bilirrubina total no sangue.'),
('Bilirrubina Direta', 'Avaliação dos níveis de bilirrubina direta no sangue.'),
('Bilirrubina Indireta', 'Avaliação dos níveis de bilirrubina indireta no sangue.'),
('Albumina', 'Exame para medir os níveis de albumina no sangue.'),
('Proteínas Totais', 'Avaliação dos níveis de proteínas totais no sangue.'),
('Amilase', 'Exame para avaliar a função pancreática.'),
('Lipase', 'Exame para avaliar a função pancreática.'),
('CK (Creatina Quinase)', 'Exame para avaliar lesões musculares e cardíacas.'),
('CK-MB', 'Exame para avaliar lesões cardíacas específicas.'),
('Troponina', 'Exame para diagnóstico de infarto agudo do miocárdio.');