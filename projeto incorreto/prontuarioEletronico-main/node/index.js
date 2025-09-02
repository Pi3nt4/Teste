const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');
const dbPool = require('./controllers/DAO/db');
const PacienteController = require('./controllers/pacienteController');
const ExameController = require('./controllers/ExameController');


async function testarConexaoDB() {
  try {
    await dbPool.query('SELECT 1');
    console.log('Conexão com o banco de dados estabelecida com sucesso!');
  } catch (error) {
    console.error('Erro ao conectar ao banco de dados:', error);
    process.exit(1);
  }
}
testarConexaoDB();

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// CRUD Pacientes
app.get('/api/pacientes', PacienteController.listar);
app.get('/api/pacientes/:id', PacienteController.buscarPorId);
app.post('/api/pacientes', PacienteController.cadastrar);
app.put('/api/pacientes/:id', PacienteController.editar);
app.delete('/api/pacientes/:id', PacienteController.excluir);

// CRUD Exames
app.get('/api/exames', ExameController.listar);
app.get('/api/exames/:id', ExameController.buscarPorId);
app.post('/api/exames', ExameController.cadastrar);
app.put('/api/exames/:id', ExameController.editar);
app.delete('/api/exames/:id', ExameController.excluir);

app.get('/', (req, res) => {
    res.status(200).json({ message: 'API do Sistema de Bioquimica (Simples)' });
});

// Iniciar o Servidor
app.listen(PORT, () => {
  console.log(`Servidor da API rodando na porta ${PORT}`);
  console.log(`Acesse em: http://localhost:${PORT}`);
  console.log('ExameController:', ExameController);
});