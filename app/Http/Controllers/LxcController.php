<?php

namespace App\Http\Controllers;

use App\Models\LxcRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ProxmoxApiManager;
use App\Http\Controllers\Controller;

class LxcController extends Controller
{
    private $lxcTiers = [
        'bronze' => ['cores' => 1, 'memory' => 512,  'disk' => 4],
        'silver' => ['cores' => 1, 'memory' => 1024, 'disk' => 8],
        'gold'   => ['cores' => 2, 'memory' => 2048, 'disk' => 16],
    ];
    
    public function requestLxc(Request $request) {
            $incomingFields = $request->validate([
            'machine_power' => 'required|string|in:bronze,silver,gold',
            'details' => 'max:500',
        ]);
    $incomingFields['user_id'] = auth()->id();
    LxcRequest::create($incomingFields);
    return redirect('/')->with('success', 'LXC request submitted successfully.');
    }

    public function approveRequest($id) {
        if (auth()->user() && auth()->user()->role === 'admin') {
            $lxcRequest = LxcRequest::find($id);
            $lxcRequest->status = 'approved';
            $lxcRequest->save();
        }
        return redirect('/');
    }

    public function denyRequest($id) {
        if (auth()->user() && auth()->user()->role === 'admin') {
            $lxcRequest = LxcRequest::find($id);
            $lxcRequest->status = 'denied';
            $lxcRequest->save();
        }
        return redirect('/');
    }

    public function createLxc($id) {
        $lxcRequest = LxcRequest::find($id);
        if ($lxcRequest && $lxcRequest->status === 'approved') {
            // Prende dai template definiti in cima
            $selectedTier = $this->lxcTiers[$lxcRequest->machine_power];
            // ID macchina virtuale
            // Proxmox richiede ID >= 100
            // Ho preso il mio range di ID anche se non so se necessario
            // Ho fatto 10 in più così non va in conflitto con altre macchine fatte in classe
            // Deve essere anche unico tra le VM quindi prendo l'ID unico della richiesta
            $vmid = 3410 + $lxcRequest->id;
            // Nome più o meno casuale
            $hostname = 'lxc-' . $lxcRequest->user_id . '-' . time();
            // Password random
            $password = Str::random(16);
            $apiManager = new ProxmoxApiManager();
            // Aiuto di ChatGPT per alcuni problemi con la chiamata API
            $response = $apiManager->createLxc([
                'vmid' => $vmid,
                'hostname' => $hostname,
                'memory' => $selectedTier['memory'],
                'cores' => $selectedTier['cores'],
                // Scelto local-lvm per il disco
                // Locale al nodo + buona performance per i container + allocazione dinamica
                // Inoltre meno problematico da configurare
                'rootfs' => "local-lvm:{$selectedTier['disk']}",
                // Bridge a vmbr0 (host only) + IP assegnato con DHCP, permette accesso da host
                // Fornisce al container IP del tipo 192.168.56.x
                'net0' => 'name=eth0,bridge=vmbr0,ip=dhcp',
                // Bridge a vmbr1 (NAT), permette accesso a internet
                'net1' => 'name=eth1,bridge=vmbr1,ip=dhcp',
                'password' => $password,
                // ! Rende root dentro il container diverso dal root dell'host
                // Evita che l'utente del container possa fare danni !
                'unprivileged' => 1,
                // Serve l'OS per il LXC
                // vztmpl è una cartella speciale di Proxmox dove vengono tenuti i template
                // alpine era quello che avevo già e quindi ho usato quello
                'ostemplate' => 'local:vztmpl/alpine-3.22-default_20250617_amd64.tar.xz',
            ]);
            // dd($response->status(), $response->headers(), $response->body());
            // dd($response);
            $lxcRequest->status = 'created';
            $lxcRequest->save();
            return view('lxc_creation_success', ['vmid' => $vmid, 'hostname' => $hostname, 'password' => $password]);
        }
        else {
            return redirect('/')->withErrors(['lxcRequest.approved' => 'LXC request must be approved.']);
        }
    }
}
