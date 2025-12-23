<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Admin Page</title>
    </head>
    <body>
        <form action="/logout" method="post">
            @csrf
            <input type="submit" class="button-link top-left" value="Logout">
        </form>
        <div class="c-info-container">
            <h2 class="list-title">Pending LXC Requests</h2>
            <div class="v-info-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Machine Power</th>
                            <th>Details</th>
                            <th>Requester</th>
                            <th>Approve</th>
                            <th>Deny</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lxcRequests as $lxcRequest)
                            @if ($lxcRequest->status === 'pending')
                                <tr>
                                    <td class="cell-text">{{ $lxcRequest['machine_power'] }}</td>
                                    <td>
                                        <div class="scroll-box">
                                            {{ $lxcRequest['details'] }}
                                        </div>
                                    </td>
                                     <td>
                                        <div class="cell-text">
                                            {{ $lxcRequest->user->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <form
                                            action="/approve-request/{{ $lxcRequest['id'] }}"
                                            method="post"
                                            class="form"
                                            onsubmit="return confirm('Are you sure? This will allow the machine creation.')">
                                            @csrf
                                            <input type="submit" class="danger-button cell-text" value="Approve">
                                        </form>
                                    </td>
                                    <td>
                                        <form
                                            action="/deny-request/{{ $lxcRequest['id'] }}"
                                            method="post"
                                            class="form"
                                            onsubmit="return confirm('Are you sure? This will prevent the machine creation.')">
                                            @csrf
                                            <input type="submit" class="danger-button cell-text" value="Deny">
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>