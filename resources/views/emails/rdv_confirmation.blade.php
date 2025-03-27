<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de RDV</title>
</head>
<body>
    <h2>Bonjour {{ $user->name }},</h2>
    <p>Votre rendez-vous est confirmé pour le créneau : {{ \Carbon\Carbon::parse($creneau->date)->locale('fr')->translatedFormat('d F Y') }} de {{ $creneau->heure_debut }} à {{ $creneau->heure_fin }}</p>
    <p>Merci de votre confiance.</p>
</body>
</html>