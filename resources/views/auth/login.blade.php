<!-- This HTML template represents a simple login form for the Holiday Plans application. -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title -->
    <title>@yield('title', 'Holiday Plans')</title>
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <!-- Container for the login form -->
    <div class="container">
        <!-- Login form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf <!-- CSRF token -->

            <!-- Login title -->
            <h2>Login</h2>
            
            <!-- Email input -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <!-- Password input -->
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Login</button>
        </form>

        <!-- Error messages -->
        @if ($errors->any())
            <div class="error-container">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif    
    </div>
</body>
</html>
