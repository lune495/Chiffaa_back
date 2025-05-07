<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat Médical</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #444;
        }
        .header p {
            font-size: 14px;
            margin: 5px 0;
            color: #666;
        }
        .content {
            line-height: 1.8;
            font-size: 16px;
        }
        .content p {
            margin: 10px 0;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
        }
        .signature p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
        .highlight {
            font-weight: bold;
            color: #000;
        }
        .line {
            border-bottom: 1px dashed #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CENTRE MEDICO-SOCIAL CHIFAA</h1>
            <p>N° 023 Parcelles Assainies - Unité 24</p>
            <p>Tél. : 33 821 25 12 / 70 984 53 34 / 77 270 72 22</p>
        </div>

        <div class="content">
            <p>Je soussigné <span class="highlight">Docteur {{ $data['nom_medecin'] }}</span>, certifie avoir examiné ce jour <span class="highlight">{{ $data['date_examen'] }}</span> :</p>
            <div class="line"></div>
            <p>Nom du patient : <span class="highlight">{{ $data['nom_patient'] }}</span></p>
            <p>et constaté que son état de santé nécessite :</p>
            <p class="highlight">{{ $data['motif_arret'] }}</p>
            <p>Durée de repos : <span class="highlight">{{ $data['duree_repos'] }} jours</span></p>
            <p>Du : <span class="highlight">{{ $data['date_debut_arret'] }}</span> au <span class="highlight">{{ $data['date_fin_arret'] }}</span></p>
        </div>

        <div class="signature">
            <p>Fait à : .............................................</p>
            <p>Le : .............................................</p>
            <p>Signature :</p>
        </div>

        <div class="footer">
            <p>En foi de quoi je lui établis et délivre le présent certificat pour servir et valoir ce que de droit.</p>
        </div>
    </div>
</body>
</html>