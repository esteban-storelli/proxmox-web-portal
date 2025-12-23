<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProxmoxApiManager
{
	private string $baseUrl;
	private string $apiToken;
    private string $nodeIp;
    private string $nodeName;

	public function __construct()
	{
        // Prendere da .env
		$this->apiToken = env('PROXMOX_API_TOKEN');
        $this->nodeIp = env("PROXMOX_TARGET_NODE_IP");
        $this->nodeName = env("PROXMOX_TARGET_NODE_NAME");

		// URL base per richiesta all'API di Proxmox
		// Serve l'IP di uno dei nodi, preso da .env
		$this->baseUrl = "https://{$this->nodeIp}:8006/api2/json";
	}

	// Wrapper per richieste HTTP all'API di Proxmox
	protected function request(string $method, string $endpoint, array $data = [])
	{
        $response = Http::withHeaders([
			// Token per autenticazione (preso da .env, formato user@pam!nome_token=token)
            'Authorization' => "PVEAPIToken={$this->apiToken}"
			//Disabilita SSL, converrebbe importare il certificato di Proxmox...
			// $method = get/post/... dinamico in base alla richiesta
			// Dati in formato JSON come richiede l'API
        ])->withoutVerifying()->$method("{$this->baseUrl}{$endpoint}", $data);        

		// Ritorna risposta per debugging (es. tramite dd($request))
		return $response;
	}

	public function createLxc($config)
	{
		// Metodo POST
		// Endpoint richiesto per creare LXC
		// Serve il nome di uno dei nodi, passato tramite .env
		// Configurazione JSON passata dal controller
		return $this->request('post', '/nodes/' . $this->nodeName . '/lxc', $config);
	}
}
