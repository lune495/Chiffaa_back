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

class GenerateExcelExport implements FromArray, WithHeadings, WithStyles, WithEvents
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

        // Ajouter les données des logs
        foreach ($this->results['data'] as $log) {
            $data[] = [
                'Désignation' => $log->designation,
                'Total Prix' => $log->total_prix,
            ];
            $totalRecette += $log->total_prix;
        }

        // Ajouter les dépenses
        foreach ($this->results['depenses'] as $depense) {
            $data[] = [
                'Désignation' => 'Dépense: ' . $depense->nom,
                'Total Prix' => $depense->montant,
            ];
            $totalDepense += $depense->montant;
        }

        // Ajouter les informations de la pharmacie
        if (isset($this->results['pharmacie'])) {
            $data[] = [
                'Désignation' => 'Pharmacie',
                'Total Prix' => $this->results['pharmacie'],
            ];
            $totalRecette += $this->results['pharmacie'];
        }

        // Ajouter les totaux
        $data[] = [
            'Désignation' => 'Total Recette',
            'Total Prix' => $totalRecette,
        ];
        $data[] = [
            'Désignation' => 'Total Dépense',
            'Total Prix' => $totalDepense,
        ];
        $data[] = [
            'Désignation' => 'Solde Caisse',
            'Total Prix' => $totalRecette - $totalDepense,
        ];

        return $data;
    }

    public function headings(): array
    {
        return [
            'Désignation',
            'Total Prix',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Appliquer des styles globaux
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Appliquer des bordures à toutes les cellules
        $sheet->getStyle('A1:B' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Centrer le texte dans toutes les colonnes
        $sheet->getStyle('A1:B' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function registerEvents(): array
    {
        return [
            // Ajuster automatiquement la largeur des colonnes
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
            },
        ];
    }
}