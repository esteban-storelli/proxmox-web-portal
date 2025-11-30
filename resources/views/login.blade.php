<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
        <title>Login Page</title>
    </head>
    <body>
        <div class="c-info-container">
            <div class="v-info-container">
                <form action="/login" method="POST" class="form">
                    @csrf
                    <input type="text" name="email", id="email", placeholder="Email" class="form-input">
                    <input type="password" name="password", id="password", placeholder="Password" class="form-input">
                    <input type="submit" class="button-link">
                </form>
            </div>
        </div>
    </body>
</html>