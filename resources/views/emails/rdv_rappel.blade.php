<!DOCTYPE html>
<html>
<head>
    <title>Rappel de votre rendez-vous</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>
    <p>Ceci est un rappel pour votre rendez-vous prévu le <strong>{{ \Carbon\Carbon::parse($creneau->date)->locale('fr')->translatedFormat('d F Y') }}</strong> de <strong>{{ $creneau->heure_debut }}</strong> à <strong>{{ $creneau->heure_fin }}</strong>.</p>
    <p>Merci d’arriver quelques minutes à l’avance.</p>
    <p>À très bientôt.</p>
</body>
</html>