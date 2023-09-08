@extends('pdf.layouts.layout-export2')
@section('title', "Situation Generale")
@section('content')

    <table style="border: none;font-size: 11px; margin-top:0px">
        <tr  style="border: none">
            <td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td><td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none">
                <div> 
                </div>
            </td>
            <td style="border:none;"></td>
        </tr>
    </table>
    <center><h4 style="margin:0">Situation Generale du  {{$derniere_date_fermeture}} au {{$current_date}}</h4></center>
    <br>
    <div class="static">
    <table class="table table-bordered">
        <tr>
            <th style="border:none"> <p class="badge">DESIGNATION</p> </th>
            <th style="border:none"><p class="badge">MONTANT</p></th>
        </tr>
    <tbody style="border:none">
        {{$montant_total = 0}}
        @foreach($data as $sum)
            {{$montant_total = $montant_total + $sum->total_prix }}
            <tr>
                <td style="font-size:12px;padding: 6px;line-height:15px"><center> {{ \App\Models\Outil::premereLettreMajuscule($sum->designation)}}</center></td>
                    <td style="font-size:12px;padding: 6px"> <center>{{$sum->total_prix}}</center></td>
            </tr>
        @endforeach

        <!--total-->
        <tr>
        <div>
                <p class="badge" style="line-height:15px;">Total</p>
                <p style="line-height
                :5px;text-align:center">{{ \App\Models\Outil::formatPrixToMonetaire($montant_total, false, false)}}</p>
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"  style="padding-top : 10px;font-size: 11px">
                <p >Arretée à la somme de :</p>  
                <p style="font-weight: bold;font-size: 11px">{{$montant_total !=0 ? $montant_total : $montant_total}}</p> 
            </td>
        </tr>
    </tbody>
</table>
</div>
@endsection