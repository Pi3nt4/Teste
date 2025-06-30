
function getClientes(){
    const cli = [
        {id: 1, nome: "Universidade Positivo", cnpj: "12345678910", datafundacao: "01/02/2000"},
        {id: 2, nome: "Universidade Estadual de Londrina", cnpj: "12345678999", datafundacao: "13/04/1974"},
        {id: 3, nome: "Universidade Federal do Paraná", cnpj: "12345678925", datafundacao: "23/06/1950"},
        {id: 4, nome: "Universidade de Campinas", cnpj: "12345678944", datafundacao: "03/03/1942"}
    ];

    return cli;
}

function insertCliente(idInformado, nomeInformado, cnpjInformado, datafundacaoInformado){
    if(idInformado && nomeInformado && cnpjInformado && datafundacaoInformado){
        const novoCliente = {
            id: idInformado,
            nome: nomeInformado,
            cnpj: cnpjInformado,
            datafundacao: datafundacaoInformado
        }
        console.log("Cliente inserido: ", novoCliente);
        return true;
    }
    console.error("Falha ao inserir cliente, faltou algum valor");
    return false;
}

module.exports = {getClientes, insertCliente};