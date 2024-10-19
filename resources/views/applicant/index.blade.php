<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Applicant</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <ul>
            <li><a href="#">View Applications</a></li>
            <li><a href="#">Edit Profile</a></li>
            <li><a href="#">Support</a></li>
        </ul>

       <!-- Logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit">Logout</button>
</form>

    </div>
</body>
</html>
