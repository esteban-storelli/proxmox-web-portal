<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Home Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <h2 class="list-title">Request the Creation of a New LXC</h1>
            <div class="v-info-container">
                <form action="/request-lxc" method="post" class="form">
                    @csrf
                    <select name="machine_power" id="machine-power" class="form-input">
                        <option value="" selected disabled>Machine Power</option>
                        <option value="bronze">Bronze</option>
                        <option value="silver">Silver</option>
                        <option value="gold">Gold</option>
                    </select>
                    <textarea name="details" id="details" class="form-input" placeholder="Details..."></textarea>
                    <input type="submit" class="form-input button" value="Request Creation">
                </form>
            </div>
        </div>
        <div class="c-info-container">
	        <h2 class="list-title">My LXC Requests</h2>
            <div class="v-info-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Machine Power</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Create</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->lxcRequests as $lxcRequest)
                            <tr>
                                <td class="cell-text">
                                    {{ $lxcRequest['machine_power'] }}
                                </td>
                                <td>
                                    <div class="scroll-box">
                                        {{ $lxcRequest['details'] }}
                                    </div>
                                </td>
                                <td class="cell-text">
                                    {{ $lxcRequest['status'] }}
                                </td>
                                <td class="cell-text">
                                    <form
                                        action="/create-lxc/{{ $lxcRequest['id'] }}"
                                        method="post"
                                        onsubmit="return confirm('Are you sure? This will create the LXC.')">
                                        @csrf
                                        <input type="submit" class="danger-button" value="Create">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>