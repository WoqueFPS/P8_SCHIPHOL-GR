<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="login-admin-dashboard-page">
    <div class="login-admin-dashboard-card">
        <div class="login-admin-dash-logo">AMS</div>
        <h1>Welkom, {{ $staff->name }}</h1>
        
        <form method="POST" action="{{ route('staff.logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="login-admin-btn-logout">Uitloggen</button>
        </form>
    </div>
</div>
</body>
</html>