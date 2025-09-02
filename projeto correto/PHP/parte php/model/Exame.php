<?php

class Exame {

    // Atributos da tabela 'exames'
    private $id;
    private $paciente_id;
    private $tipo_exame;
    private $status;
    private $data_inicio;
    private $data_finalizado;
    private $resultado_final;

    // Atributos da tabela 'analises_dados'
    // Etapa 1
    private $urina_agar_cled_qtd_colonias;
    private $urina_agar_cled_lote;
    private $urina_agar_cled_validade;
    private $escarro_ziehl_resultado;
    private $escarro_ziehl_lote;
    private $escarro_ziehl_validade;

    // Etapa 2
    private $gram_resultado;
    private $gram_lote;
    private $gram_validade;

    // Caminho Gram-Positivo
    private $gp_agar_manitol_qtd_colonias;
    private $gp_agar_manitol_coloracao;
    private $gp_agar_manitol_lote;
    private $gp_agar_manitol_validade;
    private $gp_catalase_resultado;
    private $gp_catalase_lote;
    private $gp_catalase_validade;
    private $gp_coagulase_resultado;
    private $gp_coagulase_lote_reagente;
    private $gp_coagulase_validade_reagente;
    private $gp_coagulase_lote_tubo;
    private $gp_coagulase_validade_tubo;
    private $gp_novobiocina_resultado;
    private $gp_novobiocina_lote_antibiotico;
    private $gp_novobiocina_validade_antibiotico;
    private $gp_novobiocina_lote_agar;

    // Caminho Gram-Negativo
    private $gn_agar_macconkey_qtd_colonias;
    private $gn_agar_macconkey_coloracao;
    private $gn_agar_macconkey_lote;
    private $gn_agar_macconkey_validade;
    private $gn_epm_gas;
    private $gn_epm_h2s;
    private $gn_epm_ureia;
    private $gn_epm_triptofano;
    private $gn_epm_lote;
    private $gn_epm_validade;
    private $gn_mili_indol;
    private $gn_mili_lisina;
    private $gn_mili_motilidade;
    private $gn_mili_lote;
    private $gn_mili_validade;
    private $gn_citrato_utilizacao;
    private $gn_citrato_lote;
    private $gn_citrato_validade;
    
    // --- GETTERS E SETTERS ---
    // (Pode minimizar esta secção no seu editor de código para facilitar a leitura)

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getPacienteId() { return $this->paciente_id; }
    public function setPacienteId($paciente_id) { $this->paciente_id = $paciente_id; }

    public function getTipoExame() { return $this->tipo_exame; }
    public function setTipoExame($tipo_exame) { $this->tipo_exame = $tipo_exame; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getDataInicio() { return $this->data_inicio; }
    public function setDataInicio($data_inicio) { $this->data_inicio = $data_inicio; }

    public function getDataFinalizado() { return $this->data_finalizado; }
    public function setDataFinalizado($data_finalizado) { $this->data_finalizado = $data_finalizado; }

    public function getResultadoFinal() { return $this->resultado_final; }
    public function setResultadoFinal($resultado_final) { $this->resultado_final = $resultado_final; }

    public function getUrinaAgarCledQtdColonias() { return $this->urina_agar_cled_qtd_colonias; }
    public function setUrinaAgarCledQtdColonias($urina_agar_cled_qtd_colonias) { $this->urina_agar_cled_qtd_colonias = $urina_agar_cled_qtd_colonias; }

    public function getUrinaAgarCledLote() { return $this->urina_agar_cled_lote; }
    public function setUrinaAgarCledLote($urina_agar_cled_lote) { $this->urina_agar_cled_lote = $urina_agar_cled_lote; }

    public function getUrinaAgarCledValidade() { return $this->urina_agar_cled_validade; }
    public function setUrinaAgarCledValidade($urina_agar_cled_validade) { $this->urina_agar_cled_validade = $urina_agar_cled_validade; }

    public function getEscarroZiehlResultado() { return $this->escarro_ziehl_resultado; }
    public function setEscarroZiehlResultado($escarro_ziehl_resultado) { $this->escarro_ziehl_resultado = $escarro_ziehl_resultado; }

    public function getEscarroZiehlLote() { return $this->escarro_ziehl_lote; }
    public function setEscarroZiehlLote($escarro_ziehl_lote) { $this->escarro_ziehl_lote = $escarro_ziehl_lote; }

    public function getEscarroZiehlValidade() { return $this->escarro_ziehl_validade; }
    public function setEscarroZiehlValidade($escarro_ziehl_validade) { $this->escarro_ziehl_validade = $escarro_ziehl_validade; }

    public function getGramResultado() { return $this->gram_resultado; }
    public function setGramResultado($gram_resultado) { $this->gram_resultado = $gram_resultado; }

    public function getGramLote() { return $this->gram_lote; }
    public function setGramLote($gram_lote) { $this->gram_lote = $gram_lote; }

    public function getGramValidade() { return $this->gram_validade; }
    public function setGramValidade($gram_validade) { $this->gram_validade = $gram_validade; }

    public function getGpAgarManitolQtdColonias() { return $this->gp_agar_manitol_qtd_colonias; }
    public function setGpAgarManitolQtdColonias($gp_agar_manitol_qtd_colonias) { $this->gp_agar_manitol_qtd_colonias = $gp_agar_manitol_qtd_colonias; }

    public function getGpAgarManitolColoracao() { return $this->gp_agar_manitol_coloracao; }
    public function setGpAgarManitolColoracao($gp_agar_manitol_coloracao) { $this->gp_agar_manitol_coloracao = $gp_agar_manitol_coloracao; }

    public function getGpAgarManitolLote() { return $this->gp_agar_manitol_lote; }
    public function setGpAgarManitolLote($gp_agar_manitol_lote) { $this->gp_agar_manitol_lote = $gp_agar_manitol_lote; }

    public function getGpAgarManitolValidade() { return $this->gp_agar_manitol_validade; }
    public function setGpAgarManitolValidade($gp_agar_manitol_validade) { $this->gp_agar_manitol_validade = $gp_agar_manitol_validade; }

    public function getGpCatalaseResultado() { return $this->gp_catalase_resultado; }
    public function setGpCatalaseResultado($gp_catalase_resultado) { $this->gp_catalase_resultado = $gp_catalase_resultado; }

    public function getGpCatalaseLote() { return $this->gp_catalase_lote; }
    public function setGpCatalaseLote($gp_catalase_lote) { $this->gp_catalase_lote = $gp_catalase_lote; }

    public function getGpCatalaseValidade() { return $this->gp_catalase_validade; }
    public function setGpCatalaseValidade($gp_catalase_validade) { $this->gp_catalase_validade = $gp_catalase_validade; }

    public function getGpCoagulaseResultado() { return $this->gp_coagulase_resultado; }
    public function setGpCoagulaseResultado($gp_coagulase_resultado) { $this->gp_coagulase_resultado = $gp_coagulase_resultado; }

    public function getGpCoagulaseLoteReagente() { return $this->gp_coagulase_lote_reagente; }
    public function setGpCoagulaseLoteReagente($gp_coagulase_lote_reagente) { $this->gp_coagulase_lote_reagente = $gp_coagulase_lote_reagente; }

    public function getGpCoagulaseValidadeReagente() { return $this->gp_coagulase_validade_reagente; }
    public function setGpCoagulaseValidadeReagente($gp_coagulase_validade_reagente) { $this->gp_coagulase_validade_reagente = $gp_coagulase_validade_reagente; }

    public function getGpCoagulaseLoteTubo() { return $this->gp_coagulase_lote_tubo; }
    public function setGpCoagulaseLoteTubo($gp_coagulase_lote_tubo) { $this->gp_coagulase_lote_tubo = $gp_coagulase_lote_tubo; }

    public function getGpCoagulaseValidadeTubo() { return $this->gp_coagulase_validade_tubo; }
    public function setGpCoagulaseValidadeTubo($gp_coagulase_validade_tubo) { $this->gp_coagulase_validade_tubo = $gp_coagulase_validade_tubo; }

    public function getGpNovobiocinaResultado() { return $this->gp_novobiocina_resultado; }
    public function setGpNovobiocinaResultado($gp_novobiocina_resultado) { $this->gp_novobiocina_resultado = $gp_novobiocina_resultado; }

    public function getGpNovobiocinaLoteAntibiotico() { return $this->gp_novobiocina_lote_antibiotico; }
    public function setGpNovobiocinaLoteAntibiotico($gp_novobiocina_lote_antibiotico) { $this->gp_novobiocina_lote_antibiotico = $gp_novobiocina_lote_antibiotico; }

    public function getGpNovobiocinaValidadeAntibiotico() { return $this->gp_novobiocina_validade_antibiotico; }
    public function setGpNovobiocinaValidadeAntibiotico($gp_novobiocina_validade_antibiotico) { $this->gp_novobiocina_validade_antibiotico = $gp_novobiocina_validade_antibiotico; }
    
    public function getGpNovobiocinaLoteAgar() { return $this->gp_novobiocina_lote_agar; }
    public function setGpNovobiocinaLoteAgar($gp_novobiocina_lote_agar) { $this->gp_novobiocina_lote_agar = $gp_novobiocina_lote_agar; }

    public function getGnAgarMacconkeyQtdColonias() { return $this->gn_agar_macconkey_qtd_colonias; }
    public function setGnAgarMacconkeyQtdColonias($gn_agar_macconkey_qtd_colonias) { $this->gn_agar_macconkey_qtd_colonias = $gn_agar_macconkey_qtd_colonias; }

    public function getGnAgarMacconkeyColoracao() { return $this->gn_agar_macconkey_coloracao; }
    public function setGnAgarMacconkeyColoracao($gn_agar_macconkey_coloracao) { $this->gn_agar_macconkey_coloracao = $gn_agar_macconkey_coloracao; }

    public function getGnAgarMacconkeyLote() { return $this->gn_agar_macconkey_lote; }
    public function setGnAgarMacconkeyLote($gn_agar_macconkey_lote) { $this->gn_agar_macconkey_lote = $gn_agar_macconkey_lote; }

    public function getGnAgarMacconkeyValidade() { return $this->gn_agar_macconkey_validade; }
    public function setGnAgarMacconkeyValidade($gn_agar_macconkey_validade) { $this->gn_agar_macconkey_validade = $gn_agar_macconkey_validade; }

    public function getGnEpmGas() { return $this->gn_epm_gas; }
    public function setGnEpmGas($gn_epm_gas) { $this->gn_epm_gas = $gn_epm_gas; }

    public function getGnEpmH2s() { return $this->gn_epm_h2s; }
    public function setGnEpmH2s($gn_epm_h2s) { $this->gn_epm_h2s = $gn_epm_h2s; }

    public function getGnEpmUreia() { return $this->gn_epm_ureia; }
    public function setGnEpmUreia($gn_epm_ureia) { $this->gn_epm_ureia = $gn_epm_ureia; }

    public function getGnEpmTriptofano() { return $this->gn_epm_triptofano; }
    public function setGnEpmTriptofano($gn_epm_triptofano) { $this->gn_epm_triptofano = $gn_epm_triptofano; }

    public function getGnEpmLote() { return $this->gn_epm_lote; }
    public function setGnEpmLote($gn_epm_lote) { $this->gn_epm_lote = $gn_epm_lote; }

    public function getGnEpmValidade() { return $this->gn_epm_validade; }
    public function setGnEpmValidade($gn_epm_validade) { $this->gn_epm_validade = $gn_epm_validade; }

    public function getGnMiliIndol() { return $this->gn_mili_indol; }
    public function setGnMiliIndol($gn_mili_indol) { $this->gn_mili_indol = $gn_mili_indol; }

    public function getGnMiliLisina() { return $this->gn_mili_lisina; }
    public function setGnMiliLisina($gn_mili_lisina) { $this->gn_mili_lisina = $gn_mili_lisina; }

    public function getGnMiliMotilidade() { return $this->gn_mili_motilidade; }
    public function setGnMiliMotilidade($gn_mili_motilidade) { $this->gn_mili_motilidade = $gn_mili_motilidade; }

    public function getGnMiliLote() { return $this->gn_mili_lote; }
    public function setGnMiliLote($gn_mili_lote) { $this->gn_mili_lote = $gn_mili_lote; }

    public function getGnMiliValidade() { return $this->gn_mili_validade; }
    public function setGnMiliValidade($gn_mili_validade) { $this->gn_mili_validade = $gn_mili_validade; }

    public function getGnCitratoUtilizacao() { return $this->gn_citrato_utilizacao; }
    public function setGnCitratoUtilizacao($gn_citrato_utilizacao) { $this->gn_citrato_utilizacao = $gn_citrato_utilizacao; }

    public function getGnCitratoLote() { return $this->gn_citrato_lote; }
    public function setGnCitratoLote($gn_citrato_lote) { $this->gn_citrato_lote = $gn_citrato_lote; }

    public function getGnCitratoValidade() { return $this->gn_citrato_validade; }
    public function setGnCitratoValidade($gn_citrato_validade) { $this->gn_citrato_validade = $gn_citrato_validade; }
}