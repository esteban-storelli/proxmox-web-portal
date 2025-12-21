<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Admin Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <h2 class="list-title">My VM Requests</h2>
            <div class="h-info-container">
                <h2 class="header">Machine Power</h2>
                <h2 class="header">Details</h2>
                <h2 class="header">Status</h2>
            </div>
            <div class="v-info-container">
                @foreach (auth()->user()->vmRequests as $vmRequest)
                    <div class="h-info-container">
                        <h3 class="info-text">{{ $vmRequest['machine_power'] }}</h3>
                        <div class="scroll-box">{{ $vmRequest['details'] }}</div>
                        <h3 class="info-text">{{ $vmRequest['status'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>