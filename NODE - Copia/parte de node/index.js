// 1. Importar os módulos necessários
const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');

// 2. Inicializar o aplicativo Express
const app = express();
const PORT = process.env.PORT || 3000;

// 3. Configurar o Body Parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// 4. Configurar a Conexão com o Banco de Dados MySQL
const dbPool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '', 
    database: 'teste', // <<-- IMPORTANTE: Verifique se 'teste' é o nome correto do seu banco de dados
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
}).promise(); // O .promise() permite usar async/await

// 5. Rota Inicial da API
app.get('/', (req, res) => {
    res.status(200).json({ message: 'API do Sistema de Laboratório de Microbiologia - Conectada ao BD' });
});


// --- ROTAS CRUD FUNCIONAIS PARA PACIENTES ---

// ROTA 1: Listar todos os pacientes (READ all)
app.get('/api/pacientes', async (req, res) => {
    try {
        const sql = "SELECT * FROM pacientes ORDER BY nome ASC";
        const [rows] = await dbPool.execute(sql);
        res.status(200).json(rows);
    } catch (error) {
        console.error('Erro ao buscar pacientes:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

// ROTA 2: Buscar um paciente específico pelo ID (READ by ID)
app.get('/api/pacientes/:id', async (req, res) => {
    const { id } = req.params;
    try {
        const sql = 'SELECT * FROM pacientes WHERE id = ?';
        const [rows] = await dbPool.execute(sql, [id]);
        if (rows.length > 0) {
            res.status(200).json(rows[0]);
        } else {
            res.status(404).json({ message: `Paciente com ID ${id} não encontrado.` });
        }
    } catch (error) {
        console.error('Erro ao buscar paciente por ID:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

// ROTA 3: Cadastrar um novo paciente (CREATE)
app.post('/api/pacientes', async (req, res) => {
    const { nome, cpf, dataNascimento, email } = req.body;
    if (!nome || !cpf || !dataNascimento) {
        return res.status(400).json({ message: 'Dados incompletos. Nome, CPF e Data de Nascimento são obrigatórios.' });
    }
    try {
        const sql = 'INSERT INTO pacientes (nome, cpf, data_nascimento, email) VALUES (?, ?, ?, ?)';
        const [result] = await dbPool.execute(sql, [nome, cpf, dataNascimento, email]);
        const novoPaciente = { id: result.insertId, nome, cpf, dataNascimento, email };
        res.status(201).json({ message: 'Paciente cadastrado com sucesso!', paciente: novoPaciente });
    } catch (error) {
        console.error('Erro ao inserir paciente:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

/// ROTA 4: Atualizar um paciente existente (UPDATE) - COM BANCO DE DADOS
app.put('/api/pacientes/:id', async (req, res) => {
    const { id } = req.params; // Pega o ID da URL
    const { nome, cpf, dataNascimento, email } = req.body; // Pega os novos dados do corpo da requisição

    console.log(`Recebida requisição PUT em /api/pacientes/${id}`);

    // Validação dos dados
    if (!nome || !cpf || !dataNascimento) {
        return res.status(400).json({ message: 'Dados incompletos para atualização. Nome, CPF e Data de Nascimento são obrigatórios.' });
    }

    try {
        const sql = 'UPDATE pacientes SET nome = ?, cpf = ?, data_nascimento = ?, email = ? WHERE id = ?';
        const values = [nome, cpf, dataNascimento, email, id];

        const [result] = await dbPool.execute(sql, values);

        // Verifica se alguma linha foi de fato alterada no banco
        if (result.affectedRows > 0) {
            res.status(200).json({ message: `Paciente com ID ${id} atualizado com sucesso.` });
        } else {
            // Se nenhuma linha foi afetada, significa que não foi encontrado um paciente com esse ID
            res.status(404).json({ message: `Paciente com ID ${id} não encontrado para atualização.` });
        }
    } catch (error) {
        console.error('Erro ao atualizar paciente:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

/// ROTA 5: Excluir um paciente (DELETE) - COM BANCO DE DADOS
app.delete('/api/pacientes/:id', async (req, res) => {
    const { id } = req.params; // Pega o ID da URL
    console.log(`Recebida requisição DELETE em /api/pacientes/${id}`);

    try {
        const sql = 'DELETE FROM pacientes WHERE id = ?';
        const [result] = await dbPool.execute(sql, [id]);

        if (result.affectedRows > 0) {
            res.status(200).json({ message: `Paciente com ID ${id} excluído com sucesso.` });
        } else {
            res.status(404).json({ message: `Paciente com ID ${id} não encontrado para exclusão.` });
        }
    } catch (error) {
        console.error('Erro ao excluir paciente:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

// 6. Iniciar o Servidor
app.listen(PORT, () => {
    console.log(`Servidor da API rodando na porta ${PORT}`);
    console.log(`Acesse em: http://localhost:${PORT}`);
});