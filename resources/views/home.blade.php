<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Home Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <h2 class="list-title">Request the Creation of a New VM</h1>
            <div class="v-info-container">
                <form action="/request-vm" method="post" class="form">
                    @csrf
                    {{-- <label class="text" for="machine-power">Machine Power:</label> --}}
                    <select name="machine_power" id="machine-power" class="form-input">
                        <option value="" selected disabled>Machine Power</option>
                        <option value="bronze">Bronze</option>
                        <option value="silver">Silver</option>
                        <option value="gold">Gold</option>
                    </select>
                    {{-- <label class="text" for="details">Details:</label> --}}
                    <textarea name="details" id="details" class="form-input" placeholder="Details..."></textarea>
                    <input type="submit" class="form-input" value="Request Creation">
                </form>
            </div>
        </div>
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