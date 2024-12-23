<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
            color: #343a40; /* Dark text color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0;
        }
        .error-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .error-container h1 {
            font-size: 72px; /* Large font size for the error code */
            margin-bottom: 20px;
        }
        .error-container p {
            font-size: 18px; /* Standard font size for the message */
            margin-bottom: 30px;
        }
        .btn {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
        }
        .btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <p>Forbidden: You do not have permission to access this page.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    </div>
</body>
</html>
