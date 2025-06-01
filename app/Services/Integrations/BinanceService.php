<?php

namespace App\Services\Integrations;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BinanceService
{
    protected Client $client;
    protected string $baseUrl = 'https://api.binance.com/api/v3';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 5.0,
        ]);
    }

    /**
     * Retorna o preço atual de um símbolo (ex: BTCUSDT).
     */
    public function getPrice(string $symbol): ?float
    {
        try {
            $response = $this->client->get('/ticker/price', [
                'query' => ['symbol' => strtoupper($symbol)]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return isset($data['price']) ? (float) $data['price'] : null;
        } catch (\Throwable $e) {
            Log::error("Erro ao consultar preço da Binance: " . $e->getMessage());
            return null;
        }
    }
}
