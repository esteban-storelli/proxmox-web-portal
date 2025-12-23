<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Login Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <div class="v-info-container">
                <div class="form">
                    <h3 class="header">These are your credentials for your LXC, remember them and keep them safe</h3>
                    <div class="form-input">VMID: {{ $vmid }}</div>
                    <div class="form-input">Hostname: {{ $hostname }}</div>
                    <div class="form-input">User: root</div>
                    <div class="form-input">password: {{ $password }}</div>
                </div>
            </div>
        </div>
    </body>
</html>