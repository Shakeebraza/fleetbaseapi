<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the Home Page</h1>
    <button id="authorizeButton">Authorize with HighLevel</button>

    <script>
        document.getElementById('authorizeButton').addEventListener('click', function() {
            window.location.href = "{{ route('oauth.authorize') }}";
        });
    </script>
</body>