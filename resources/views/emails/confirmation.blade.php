<!DOCTYPE html>
<html>
<head>
    <title>Activation Compte</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>
    <p>CHIFAA vous remerci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour activer votre compte :</p>
    <p><a href="{{ $confirmationUrl }}">Activer mon compte</a></p>
</body>
</html>