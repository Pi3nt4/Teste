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
// --- ROTAS PARA PROTOCOLOS DE ANÁLISE ---

// ROTA: Listar todos os protocolos disponíveis (READ all)
app.get('/api/protocolos', async (req, res) => {
    console.log('Recebida requisição GET em /api/protocolos');
    
    try {
        const sql = "SELECT * FROM protocolos ORDER BY nome_protocolo ASC";
        const [rows] = await dbPool.execute(sql);
        
        // Retorna a lista de protocolos como JSON
        res.status(200).json(rows);

    } catch (error) {
        console.error('Erro ao buscar protocolos:', error);
        res.status(500).json({ message: 'Erro interno no servidor ao buscar protocolos.' });
    }
});
// --- ROTAS PARA ANÁLISES (INICIAR UM EXAME) ---

// ROTA: Iniciar uma nova análise (CREATE)
app.post('/api/analises', async (req, res) => {
    // Para iniciar uma análise, esperamos receber o id do paciente e o id do protocolo
    const { paciente_id, protocolo_id } = req.body;
    console.log('Recebida requisição POST em /api/analises');

    // Validação simples dos dados recebidos
    if (!paciente_id || !protocolo_id) {
        return res.status(400).json({ message: 'Dados incompletos. paciente_id e protocolo_id são obrigatórios.' });
    }

    try {
        const statusInicial = 'Em Andamento'; // Status padrão ao iniciar uma análise

        const sql = 'INSERT INTO analises (paciente_id, protocolo_id, status) VALUES (?, ?, ?)';
        const values = [paciente_id, protocolo_id, statusInicial];

        // Executa a query de inserção
        const [result] = await dbPool.execute(sql, values);

        // Prepara a resposta de sucesso com os dados da nova análise
        const novaAnalise = {
            id: result.insertId, // O ID da análise que acabou de ser criada
            paciente_id: Number(paciente_id),
            protocolo_id: Number(protocolo_id),
            status: statusInicial
        };

        // Envia a resposta com status 201 (Created) e os dados da nova análise
        res.status(201).json({ message: 'Análise iniciada com sucesso!', analise: novaAnalise });

    } catch (error) {
        console.error('Erro ao iniciar nova análise:', error);
        // Verifica se o erro é de chave estrangeira (paciente ou protocolo não existe)
        if (error.code === 'ER_NO_REFERENCED_ROW_2') {
            return res.status(404).json({ message: 'Erro: Paciente ou Protocolo não encontrado com o ID fornecido.' });
        }
        res.status(500).json({ message: 'Erro interno no servidor ao iniciar análise.' });
    }
});
// ROTA: Buscar uma análise e sua ETAPA ATUAL
app.get('/api/analises/:id', async (req, res) => {
    const { id } = req.params;
    try {
        // Query para buscar a análise e os nomes
        const sqlAnalise = `SELECT a.id AS analise_id, a.status, p.nome AS paciente_nome, pr.nome_protocolo, pr.id AS protocolo_id FROM analises a JOIN pacientes p ON a.paciente_id = p.id JOIN protocolos pr ON a.protocolo_id = pr.id WHERE a.id = ?`;
        const [analiseRows] = await dbPool.execute(sqlAnalise, [id]);

        if (analiseRows.length === 0) {
            return res.status(404).json({ message: `Análise com ID ${id} não encontrada.` });
        }
        const analise = analiseRows[0];

        // Se a análise estiver finalizada, não há próxima etapa
        if (analise.status === 'Finalizado') {
            analise.etapa_atual = { nome_etapa: 'Análise Finalizada' };
            return res.status(200).json(analise);
        }

        // Busca a última etapa registrada para esta análise
        const sqlLastResult = 'SELECT etapa_id FROM resultados_etapas WHERE analise_id = ? ORDER BY id DESC LIMIT 1';
        const [lastResultRows] = await dbPool.execute(sqlLastResult, [id]);

        let etapa_atual;
        if (lastResultRows.length === 0) {
            // Se não há resultados, a etapa atual é a primeira do protocolo
            const sqlFirstStep = 'SELECT * FROM etapas_protocolo WHERE protocolo_id = ? AND etapa_anterior_id IS NULL';
            const [firstStepRows] = await dbPool.execute(sqlFirstStep, [analise.protocolo_id]);
            etapa_atual = firstStepRows[0];
        } else {
            // Se há resultados, a etapa atual é a que vem DEPOIS da última etapa registrada
            const ultimo_resultado = '...'; // Lógica para pegar o resultado condicional (ex: "Gram Positivo") do último resultado salvo
            const ultima_etapa_id = lastResultRows[0].etapa_id;
            const sqlNextStep = 'SELECT * FROM etapas_protocolo WHERE protocolo_id = ? AND etapa_anterior_id = ? AND (condicao_para_avancar = ? OR condicao_para_avancar IS NULL)';
            const [nextStepRows] = await dbPool.execute(sqlNextStep, [analise.protocolo_id, ultima_etapa_id, ultimo_resultado]);
            etapa_atual = nextStepRows[0];
        }

        analise.etapa_atual = etapa_atual;
        res.status(200).json(analise);

    } catch (error) {
        console.error('Erro ao buscar análise por ID:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});
// ROTA: Salvar o resultado de uma etapa e determinar a próxima
app.post('/api/resultados', async (req, res) => {
    const { analise_id, etapa_id, dados_formulario } = req.body;
    if (!analise_id || !etapa_id || !dados_formulario) {
        return res.status(400).json({ message: 'Dados incompletos.' });
    }
    try {
        const dadosJson = JSON.stringify(dados_formulario);
        const sqlInsert = 'INSERT INTO resultados_etapas (analise_id, etapa_id, dados_formulario) VALUES (?, ?, ?)';
        await dbPool.execute(sqlInsert, [analise_id, etapa_id, dadosJson]);

        // AGORA, VAMOS DETERMINAR A PRÓXIMA ETAPA
        // Primeiro, pegamos o ID do protocolo desta análise
        const [analiseRows] = await dbPool.execute('SELECT protocolo_id FROM analises WHERE id = ?', [analise_id]);
        if (analiseRows.length === 0) {
            return res.status(404).json({ message: 'Análise não encontrada.' });
        }
        const protocolo_id = analiseRows[0].protocolo_id;

        // Pegamos o resultado principal que define a bifurcação (se houver)
        // No nosso caso, o resultado da Coloração de Gram
        const resultadoCondicional = dados_formulario['resultado_gram'] || null;

        // Buscamos a próxima etapa no nosso mapa
        const sqlNextStep = 'SELECT * FROM etapas_protocolo WHERE protocolo_id = ? AND etapa_anterior_id = ? AND (condicao_para_avancar = ? OR condicao_para_avancar IS NULL)';
        const [nextStepRows] = await dbPool.execute(sqlNextStep, [protocolo_id, etapa_id, resultadoCondicional]);

        if (nextStepRows.length > 0) {
            // Se encontrarmos uma próxima etapa, atualizamos o status da análise
            const proximaEtapa = nextStepRows[0];
            // UPDATE analises SET status = ? WHERE id = ?', [proximaEtapa.nome_etapa, analise_id]);
            res.status(201).json({ message: 'Resultado salvo com sucesso!', proximaEtapa: proximaEtapa });
        } else {
            // Se não houver próxima etapa, a análise foi finalizada
            await dbPool.execute('UPDATE analises SET status = ? WHERE id = ?', ['Finalizado', analise_id]);
            res.status(200).json({ message: 'Resultado salvo! Análise finalizada.' });
        }

    } catch (error) {
        console.error('Erro ao salvar resultado da etapa:', error);
        res.status(500).json({ message: 'Erro interno no servidor.' });
    }
});

// 6. Iniciar o Servidor
app.listen(PORT, () => {
    console.log(`Servidor da API rodando na porta ${PORT}`);
    console.log(`Acesse em: http://localhost:${PORT}`);
});