{{-- @if (auth()->check()) --}}
@extends('pdf.layouts.layout-export2')
@section('title', "PDF Facture commande")
@section('content')

    <table style="border: none; border: none;margin-top:2px;font-size: 11px">
        <tr>
            <td style="border: none">
                <p style="font-weight: bold;font-size: 14px">C.I.S SHOWROOM</p>
                <p style="font-size: 11px">Vente de Materiels de Plomberie et Sanitaire</p>
            </td>
        </tr>
        <tr  style="border: none">
            <td  style="border: none">
                <div style="" >
                    <p  style="text-align:left;line-height:5px"> OUEST FOIRE, TALLY WALLY N°21  </p>
                    <p style="text-align:left;line-height:5px"> +221 77 348 15 82</p>
                    <p style="text-align:left;line-height:5px"> +221 77 597 55 21</p>
                </div>
            </td>
            <td style="border:none;">
                <div style="border-left: 3px solid black">
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">www.ccps.sn</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Instagram:  @ccps</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">email:  ccpsvdn@gmail.com</p>
                </div>
            </td>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
        </tr>
    </table>

    <table style="border: none;font-size: 11px; margin-top:0px">
        <tr  style="border: none">
            <td style="border: none;">
                <div>
                    <p class="badge" style="text-align:left;line-height:15px">Date</p>
                    <p style="style=border-left: 2px solid white;border-bottom: 2px solid white"></p>
                    <p style="style=border-left: 2px solid white;border-bottom: 2px solid white"></p>
                </div>
            </td>
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

    <h2 style="margin:0">Situation Genarale du  {{$start}} au {{$end}}</h2>
    <br>
    <div class="static">
    <table class="table table-bordered">
        <tr>
            <th style="border:none"> <p class="badge">DESIGNATION</p> </th>
            <th style="border:none"><p class="badge">MONTANT</p></th>
        </tr>
    <tbody style="border:none">
        {{$montant_total = 0}}
        @foreach($sumsByDesignation as $sum)
            {{$montant_total = montant_total + $sum->total_prix }}
            <tr>
                <td style="font-size:12px;padding: 6px;line-height:15px"><center> {{ \App\Models\Outil::premereLettreMajuscule($sum->designation)}}</center></td>
                    <td style="font-size:12px;padding: 6px"> <center>{{$sum->total_prix}}</center></td>
            </tr>
        @endforeach

        <!--total-->
        <tr>
                <p class="badge" style="line-height:15px;">Total HT</p>
                <p style="line-height:5px;text-align:center">{{ \App\Models\Outil::formatPrixToMonetaire($montant_total, false, false)}}</p>
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"  style="padding-top : 10px;font-size: 11px">
                <p >Arretée à la somme de :</p>  
                <p style="font-weight: bold;font-size: 11px">{{\App\Models\Outil::convertNumber($montant_total !=0 ? $montant_total : $montant_total)}}</p> 
            </td>
            <td style="padding-top : 10px;font-size: 11px" colspan="2"> <p>Conditions Règlement</p> </td>
            <td style="padding-top : 10px;font-size: 11px"> <p>ESPECES</p></td>
            <td style="padding-top : 10px;font-weight: bold;font-size: 11px" colspan="2"><p> {{\App\Models\Outil::formatPrixToMonetaire($montant_total ? $montant_total : $montant_total, false, true)}} </p></td>
        </tr>
        
    </tbody>
</table>
</div>

@endsection
{{-- @endif --}}