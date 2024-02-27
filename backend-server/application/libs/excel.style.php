<?php
$hStyle = [
    'font' => [
        'bold' => true,
        'size' => '15',
        'color' => array('rgb'=>'444444'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'006daa'],
        ],
    ],


];

$pStyle = [
    'font' => [
        'bold' => true,
        'size' => '10',
        'color' => array('rgb'=>'444444'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
];

$infoStyle = [
    'font' => [
        'size' => '8',
        'color' => array('rgb'=>'444444'),
    ],
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'006daa'],
        ],
    ],
     'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'fffefcec'
        ],
    ],

];


$thStyle = [
    'font' => [
        'bold' => true,
        'size' => '10',
        'color' => array('rgb'=>'ffffff'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'444444'],
        ],
    ],

    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FF014164',
        ],
        'endColor' => [
            'argb' => 'FF014164',
        ],
    ],
];

$thGrayStyle = [
    'font' => [
        'bold' => true,
        'size' => '10',
        'color' => array('rgb'=>'ffffff'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'444444'],
        ],
    ],

    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FF444444',
        ],
        'endColor' => [
            'argb' => 'FF444444',
        ],
    ],
];



$tdStyle = [
    'font' => [
        'size' => '10',
        'color' => array('rgb'=>'444444'),
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'444444'],
        ],
    ],
];


$cancelStyle = [
   'font' => [
        'size' => '10',
        'color' => array('rgb'=>'444444'),
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb'=>'444444'],
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'ffffff00',
        ],
    ],
];




?>
