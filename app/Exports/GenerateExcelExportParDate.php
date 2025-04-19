<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GenerateExcelExportParDate implements FromArray, WithHeadings, WithStyles, WithEvents
{
    private $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function array(): array
    {
        $data = [];
        $totalRecette = 0;
        $totalDepense = 0;

        $start = $this->results['derniere_date_fermeture'];
        $end = $this->results['current_date'];
        // $data[] = [
        //     'Désignation' => "Situation Generale du $start au $end",
        //     'Total Prix' => '',
        // ];
        // Ajouter les données des logs
        foreach ($this->results['data'] as $log) {
            $data[] = [
                'DATE' => '-',
                'N PIECE' => 0,
                'LIBELLE' => $log->designation,
                'RECETTES' => $log->total_prix,
                'DEPENSES' => 0,
            ];
            $totalRecette += $log->total_prix;
        }

         // Ajouter les informations de la pharmacie
        if (isset($this->results['pharmacie'])) {
            $data[] = [
                'DATE' => '-',
                'N PIECE' => 0,
                'LIBELLE' => 'PHARMACIE',
                'RECETTES' => $this->results['pharmacie'],
                'DEPENSES' => 0,
            ];
            $totalRecette += $this->results['pharmacie'];
        }

        // Ajouter les dépenses
        foreach ($this->results['depenses'] as $depense) {
            $data[] = [
                'DATE' => '-',
                'N PIECE' => $depense->bc,
                'LIBELLE' => $depense->nom,
                'RECETTES' => 0,
                'DEPENSES' => $depense->montant,
            ];
            $totalDepense += $depense->montant;
        }

        // Ajouter les totaux
        $data[] = [
            // 'Désignation' => 'Total Recette',
            // 'Total Prix' => $totalRecette,
            'DATE' => '-',
            'N PIECE' => '-',
            'LIBELLE' => 'Total Recette',
            'RECETTES' => $totalRecette,
            'DEPENSES' => 0,
        ];
        $data[] = [
            // 'Désignation' => 'Total Dépense',
            // 'Total Prix' => $totalDepense,
            'DATE' => '-',
            'N PIECE' => '-',
            'LIBELLE' => 'Total Dépense',
            'RECETTES' => 0,
            'DEPENSES' => $totalDepense,
        ];
        $data[] = [
            // 'Désignation' => 'Solde Caisse',
            // 'Total Prix' => $totalRecette - $totalDepense,
            'DATE' => '-',
            'N PIECE' => '-',
            'LIBELLE' => 'Solde Caisse',
            'RECETTES' => $totalRecette - $totalDepense,
            'DEPENSES' => 0,
        ];

        return $data;
    }

    public function headings(): array
    {
        return [
            'DATE',
            'N PIECE',
            'LIBELLE',
            'RECETTES',
            'DEPENSES',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Appliquer des styles globaux
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0000FF'], // Couleur bleue
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Appliquer des bordures à toutes les cellules
        $sheet->getStyle('A1:E' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Centrer le texte dans toutes les colonnes
        $sheet->getStyle('A1:E' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $start = $this->results['derniere_date_fermeture'];
                $end = $this->results['current_date'];
                $situationGenerale = "Situation Generale du $start au $end";

                // Ajuster automatiquement la largeur des colonnes
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15); // Colonne DATE
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15); // Colonne N PIECE
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(90); // Colonne LIBELLE (plus large)
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20); // Colonne RECETTES
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20); // Colonne DEPENSES
            },
        ];
    }
}