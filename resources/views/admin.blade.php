<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Admin Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <h2 class="list-title">Pending VM Requests</h2>
            <div class="h-info-container">
                <h2 class="header">Machine Power</h2>
                <h2 class="header">Details</h2>
                <h2 class="header">Approve</h2>
                <h2 class="header">Deny</h2>
            </div>
            <div class="v-info-container">
                @foreach ($vmRequests as $vmRequest)
                    <div class="h-info-container">
                        <h3 class="info-text">{{ $vmRequest['machine_power'] }}</h3>
                        <div class="scroll-box">{{ $vmRequest['details'] }}</div>
                        <form action="/approve-request/{{ $vmRequest['id'] }}" method="post" class="info-text button-spacing">
                            <input type="submit"
                            class="danger-button"
                            value="Approve"
                            onclick="return confirm('Are you sure? This will allow the machine creation.'">
                        </form>
                        <form action="/deny-request/{{ $vmRequest['id'] }}" method="post" class="info-text button-spacing">
                            <input type="submit"
                            class="danger-button"
                            value="Deny"
                            onclick="return confirm('Are you sure? This will allow the machine creation.'">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>