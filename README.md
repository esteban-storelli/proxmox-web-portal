# Come Usare

! La password dei nodi del cluster è nella loro descrizione di VirtualBox !
La password del container sul quale è hostato il sito sempre la stessa

### DB
Serva che il DB sia configurato in .env
1. Copiare .env.example e rinominarlo .env
2. Configuare le impostazioni sul database (commentate di default)
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
3. ``` php artisan migrate ```
4. ``` php artisan db:seed --class=UserSeeder ```
### API
Per far funzionare l'API di Proxmox serve che sia configurato un token, sia in .env e sia nel Datacenter.
Il modo migliore sarebbe configurare un utente con i privilegi minimi (tramite i ruoli), ma nei miei tentativi non sembrava funzionare, probabilmente mi mancavano alcuni permessi.
La soluzione che ho utilizzato è questa (non adatta a production):
1. Datacenter > Permissions > API Tokens
2. Aggiungere un nuovo token e utilizzare root@pam, nome qualsiasi
3. Privilege separation: "No" (non mi ricordo se fa differenza ma so che sicuramente funziona con No)
4. Verrà generato un token
5. Nel .env ho inserito in fondo alcuni campi da riempire
6. Va inserito il token con formato user@pam!token_name=token
7. Per far funzionare l'API serve inserire anche nome del nodo es. "px1", questo sarà dove verranno creati i LXC
8. Serve anche l'IP del nodo su cui verrà chiamata l'API, può essere lo stesso o diverso dal nodo del punto precedente es. "192.168.56.15"

Dopo queste configurazioni il sito dovrebbe funzionare.

### Funzionamento
Gli utenti sono stati inseriti dal Seeder chiamato nella configurazione del DB
user@user.com password: user
admin@admin.com password: admin
1. Creare una richiesta dalla pagina dell'utente con la potenza della macchina desiderata
2. Accettare la richiesta dalla pagina dell'admin
3. Tornando alla pagina dell'utente si può creare un LXC (solo se la richiesta è stata accettata)
4. L'LXC verrà creato nel nodo configurato in .env
5. Verranno fornite le credenziali tramite web