const express = require("express");
const bodyParser = require("body-parser");
const app = express();

const {getClientes, insertCliente} = require("../models/DAO/clienteDAO");

//Configurando para sempre receber os dados no formato JSON
app.use(bodyParser.json());
//Encondando todos os parâmetros para JSON
app.use(bodyParser.urlencoded({extended: true}));

//Configurando o express para usar o EJS como mecanismo de renderização de views padrão
app.set("view engine", "ejs");
app.set("views", "./src/views");

//Implementado rotas do tipo GET
app.get("/", (req, res) => {
    res.send("Página inicial");
})

//Listar (read) os clientes
app.get("/clientes", (req, res) => {
    const clientes = getClientes();
    console.log("Clientes cadastrados: ", clientes);

    res.render("listaclientes", {clientesDoController: clientes});
});

app.get("/api/clientes", (req, res) => {
    const clientes = getClientes();

    res.json({clientes});
})

//Exibir a página de cadastro de clientes
app.get("/cadastrarcliente", (req, res) =>{
    res.render("formcliente");
})

//Inserir (create) os clientes
app.post("/cliente", (req, res) => {
    const {id, nome, cnpj, dataFundacao} = req.body;

    const result = insertCliente(id, nome, cnpj, dataFundacao);
    if(result){
        return res.send("Cliente inserido com sucesso!");
    }
    return res.send("Não foi possível inserir o cliente");
});

app.post("/api/cliente", (req, res) => {
    const {id, nome, cnpj, dataFundacao} = req.body;
    const result = insertCliente(id, nome, cnpj, dataFundacao);
    if(result){
        return res.json({success: true});
    }
    return res.json({success: false});
})

//Exibir a página de atualiazação do cliente
app.get("/editarcliente/:idCliente", (req, res) => {
    const codCli = req.params.idCliente;
    const clientes = getClientes();
    const cliente = clientes[codCli - 1];

    res.render("formcliente", {cliente});
})

//Editar (update) o cliente
app.put("/cliente", (req, res) => {
    const {nome, cnpj} = req.body;
    //método no banco para atualizar o cliente passando (nome, cnpj)
    res.send("Cliente atualizado com sucesso");
})

//Apagando um cliente (delete)
app.delete("/cliente/:idcliente", (req, res) => {
    const codigoCliente = req.params.idcliente;
    //método no banco de dados para remover um cliente passando o id
    res.send("Cliente removido com sucesso!");
})

app.get("/fornecedores", (req, res) => {
    res.end("<html><head><title>Listagem de fornecedores</title></head><body><h3>Página de Listagem de Fornecedores</h3><h5>Lista abaixo</h5></body></html>");
})

app.listen(3000, () => {
    console.log("Servidor rodando na porta 3000");
})