<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Admin Panel</title>
    <meta http-equiv="refresh" content="5;url=login.php">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        h1 {
            margin: 0 0 20px;
            font-size: 24px;
            color: #333;
        }

        p {
            margin: 0 0 20px;
            color: #666;
        }

        .redirect-info {
            margin-top: 10px;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Panel</h1>
        <p>You are being redirected to the login page...</p>
        <div class="redirect-info">
            If you are not redirected, <a href="login.php">click here</a>.
        </div>
    </div>
</body>
</html>
