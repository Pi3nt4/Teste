<?php
class ProtocoloApiDao {
    private $apiUrl = 'http://localhost:3000/api';

    public function read() {
        $endpoint = $this->apiUrl . '/protocolos';
        $jsonResponse = @file_get_contents($endpoint);
        if ($jsonResponse === false) return [];
        return json_decode($jsonResponse, true);
    }
}
?>