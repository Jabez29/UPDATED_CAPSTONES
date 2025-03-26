<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capstone</title>
    <link rel="stylesheet" href="Assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div>
        {{ content }}

        <!-- Load jQuery FIRST -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Custom JS (Ensure Correct Path) -->
        {{ script }}

        <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </div>
</body>