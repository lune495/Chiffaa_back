@extends('pdf.layouts.layout-export2')
@section('title', "Situation Generale")
@section('content')

<h4 class="situation-heading">Historique Generale {{nom_module}} du {{$derniere_date_fermeture}} au {{$current_date}}</h4>
<div class="table-container">
    <!-- Tableau de gauche (RECETTE) -->
    <div class="table-wrapper left">
        <table class="custom-table">
            <!-- En-tête -->
            <tr>
                <th>Date</th>
                <th>Nom Patient</th>
                <th>Service</th>
                <th>Medecin</th>
                <th>Total</th>
            </tr>
            <!-- Contenu -->
            <!-- ... Votre boucle foreach existante ... -->
            {{$montant_total = 0}}
            @foreach($data as $sum)
                {{$montant_total = $montant_total + $sum->montant_total }}
                <tr>
                    <td><center> {{ $sum->created_at}}</center></td>
                    <td>{{\App\Models\Outil::toUpperCase($sum->nom_complet)}}</td>
                    <td>{{\App\Models\Outil::toUpperCase($sum->["module"]["nom"])}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2">
                    <div>
                        <p class="badge" style="line-height:15px;">Total</p>
                        <p style="line-height:5px;text-align:center">{{ \App\Models\Outil::formatPrixToMonetaire($montant_total, false, false)}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
        </table>
        <!-- ... Votre code existant ... -->

<!-- Pied de page -->
<div class="footer">
    <div class="signatures">
        <div class="signature-section left">
            <p>Signature du Principal </p>
            <!-- Ajoutez ici un espace ou une zone pour la signature du principal -->
        </div>
        <div class="signature-section right">
            <p>Signature du Caissier </p>
            <!-- Ajoutez ici un espace ou une zone pour la signature du caissier -->
        </div>
    </div>
</div>

<style>
    /* Ajoutez ce style à votre section de style existante ou à votre fichier de style externe */

    .footer {
        /* margin-top: 20px;
        padding-top: 20px; */
        text-align: center;
    }

    .signatures {
        display: flex;
        align-items: center; /* Centre les éléments verticalement */
        justify-content: space-between;
        margin-top: 10px;
        flex-wrap: nowrap;
    }

    .signature-section {
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    .left {
        text-align: left;
        flex: 1; /* Pour permettre à la signature du Principal de pousser la signature du Caissier à droite */
    }

    .right {
        text-align: right;
        flex: 1; /* Pour permettre à la signature du Caissier de pousser la signature du Principal à gauche */
    }

    /* Ajoutez des styles de signature spécifiques ici si nécessaire */
</style>

    </div>
</div>

<!-- ... Le reste de votre modèle ... -->

@endsection
