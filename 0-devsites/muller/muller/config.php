<?php

return array(

    'import' => array(

        'csvs' => array(
            'GrpStruc.csv' => 9,
            'GrpMst.csv' => 8,
            'export_web.csv' => 69
        ),

        'GrpStruc-tax' => array(
            1 => 'product-categorie',
            2 => 'merk-reeks',
            3 => 'web-reeks'
        ),

        'csvnames' => array(
            'importProductCategories' => 'GrpStruc.csv',
            'importProducts' => 'export_web.csv',
            'importMerken' => 'GrpMst.csv'
        )

    ),

    'product-categorie-templates' => array(
        1 => 'product-categorie-landing',
        2 => 'product-categorie-filter',
        3 => 'product-categorie-filter',
        4 => 'product-categorie-filter'
    ),

    'merkreeks-templates' => array(
        1 => 'merk-landing',
        2 => 'merk-reeks-filter',
        3 => 'merk-reeks-filter'
    ),

    'ftp' => array(
        'location' => '81.246.52.210',
        'login' => 'volta',
        'password' => '&eFraq2pruPr'
    ),

    'tmp_reeksoverzicht' => array(
        10  => 'Kookreeksen',
        20  => 'Messenreeksen',
        30  => 'Glasreeksen',
        35  => 'Serviezen',
        40  => 'Bestekreeksen',
        45  => 'Collecties afvalemmers'
    ), 

    'tmp_reeksoverzicht_2' => array(
        30  => 'Glasreeksen',
        35  => 'Serviezen',
        40  => 'Bestekreeksen'
    ), 

    'technical' => array(
        'intern artikelnr',
        'leveranciersartikelnr',
        'lengte (mm)', 
        'breedte (mm)', 
        'hoogte (mm)', 
        'diameter (mm)', 
        'inhoud (cl)',
        'Kleur',
        'materiaal',
        'vaatwasmachinebestendig',
        'hout',
        'kopshout',
        'met sapgeul',
        'ovenvast',
        'antikleef',
        'alle warmtebronnen incl. inductie',
        'enkel geschikt voor gas',
        'alle warmtebronnen excl. inductie',
        'geschikt voor oven',
        'microgolf',
        'organische vorm',
        'andere vormen',
        'gourmet precision',
        'veiligheidsbeugel',
        'opbergbak',
        'aantal treden',
        'afneembare weegbowl',
        'dikte staal mm',
        'materiaal handgreep',
        'ean/dun code',
        'status art.',
        'PAL',
        'verpakking',
        'afwerking'
    ),

    'status art.' => array(
        '+' => 'Beschikbaar tot uitputting voorraad',
        '+ -' => 'Uitlopend, niet op website',
        'B' => 'Product buiten gebruik',
        'D' => 'Speciaal product',
        'H' => 'Product op bestelling',
        'Pv' => 'Product in voorbereiding',
        'V' => 'Voorraadproduct',
        'V-' => 'Voorraadproduct niet op website'
    ),

    'verpakking' => array(
        '20' => 'omdoos',
        '42' => 'blister',
        '70' => 'zichtverpakking',
        '100' => 'neutrale doos',
        '200' => 'geschenkverpakking',
        '300' => 'krimpfolie',
        '400' => 'plastiek zak',
        '500' => 'zichtverpakking',
        '600' => 'ophangkaart',
        '910' => 'display',
        '915' => 'metalen blik',
        '925' => 'emmer',
        '930' => 'zichtverpakking',
        '931' => 'zichtverpakking',
        '933' => 'schaal met folie',
        '995' => 'tube',
        '996' => 'pallet'
    ),

    'filters' => array(

        /**
         * koken
        */

        2 => [
            'materiaal' => 'Materiaal'
        ],
            //kook -en stoofpannen 
            12 => [
                    'diameter/lengte-diameter' => [
                        'joins' => [ 1 => 'diameter (mm)', 2 => 'lengte (mm)'],
                        'items' => [
                            'dl1' => ['filter' => [
                                'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value <= 200 and 2_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '≤ 20cm'
                            ]],
                            'dl2' => ['filter' => [
                                'value' => '(
                                    (1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 280) 
                                    or 
                                    ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 200 and 2_meta.meta_value <= 280 and 2_meta.meta_value != 0 )
                                ) ', 
                                'count' => false, 
                                'name' => '20 t/m 28cm'
                            ]],
                            'dl3' => ['filter' => [
                                'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 280) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 280 and 2_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '> 28cm'
                            ]]
                        ]
                    ],
                    'Inhoud-inhoud (cl)' => [
                        'joins' => [ 1 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value <= 200 ', 
                                'count' => false, 
                                'name' => '≤ 2l'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and ( 1_meta.meta_value > 200 && 1_meta.meta_value <= 600 )', 
                                'count' => false, 
                                'name' => '2 t/m 6l'
                            ]],
                            'inhoud3' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value > 600 ', 
                                'count' => false, 
                                'name' => '> 6l'
                            ]]
                        ]
                    ],
                    'warmtebron-warmtebron' => [
                        'joins' => [ 
                            1 => 'alle warmtebronnen incl. inductie',
                            2 => 'alle warmtebronnen excl. inductie',
                            3 => 'enkel geschikt voor gas',
                            4 => 'geschikt voor oven'
                        ],
                        'items' => [
                            'incl inductie' => ['filter' => [ 
                                'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                                'count' => false, 
                                'name' => 'alle warmtebronnen incl. inductie'
                            ]],
                            'exclusief inductie' => ['filter' => [ 
                                'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'alle warmtebronnen exclusief inductie'
                            ]],
                            'gas' => ['filter' => [ 
                                'value' => 'item[""] == "ja"',
                                'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'enkel geschikt voor gas'
                            ]],
                            'oven' => ['filter' => [ 
                                'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'geschikt voor oven'
                            ]]
                        ]
                    ]
            ],
            //steelpannen
            13 => [        
                    'warmtebron-warmtebron' => [
                        'joins' => [ 
                            1 => 'alle warmtebronnen incl. inductie',
                            2 => 'alle warmtebronnen excl. inductie',
                            3 => 'enkel geschikt voor gas',
                            4 => 'geschikt voor oven'
                        ],
                        'items' => [
                            'incl inductie' => ['filter' => [ 
                                'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                                'count' => false, 
                                'name' => 'alle warmtebronnen incl. inductie'
                            ]],
                            'exclusief inductie' => ['filter' => [ 
                                'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'alle warmtebronnen exclusief inductie'
                            ]],
                            'gas' => ['filter' => [ 
                                'value' => 'item[""] == "ja"',
                                'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'enkel geschikt voor gas'
                            ]],
                            'oven' => ['filter' => [ 
                                'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                                'count' => false, 
                                'name' => 'geschikt voor oven'
                            ]]
                        ]
                    ]
            ],
            //braadpannen
            14 => [
                'warmtebron-warmtebron' => [
                    'joins' => [ 
                        1 => 'alle warmtebronnen incl. inductie',
                        2 => 'alle warmtebronnen excl. inductie',
                        3 => 'enkel geschikt voor gas',
                        4 => 'geschikt voor oven'
                    ],
                    'items' => [
                        'incl inductie' => ['filter' => [ 
                            'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                            'count' => false, 
                            'name' => 'alle warmtebronnen incl. inductie'
                        ]],
                        'exclusief inductie' => ['filter' => [ 
                            'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'alle warmtebronnen exclusief inductie'
                        ]],
                        'gas' => ['filter' => [ 
                            'value' => 'item[""] == "ja"',
                            'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'enkel geschikt voor gas'
                        ]],
                        'oven' => ['filter' => [ 
                            'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'geschikt voor oven'
                        ]]
                    ]
                ],
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200 ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '(
                                1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 260
                            ) ', 
                            'count' => false, 
                            'name' => '20 t/m 26cm'
                        ]],
                        'dl3' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 260', 
                            'count' => false, 
                            'name' => '> 26cm'
                        ]]
                    ]
                ],
                'antikleef-antikleef' => [
                    'joins' => [ 1 => 'antikleef'],
                    'items' => [
                        'antikleef1' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'met antikleeflaag'
                        ]],
                        'antikleef2' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'zonder antikleeflaag'
                        ]]
                    ]
                ]
            ],
            //grillpannen
            15 => [
                'warmtebron-warmtebron' => [
                    'joins' => [ 
                        1 => 'alle warmtebronnen incl. inductie',
                        2 => 'alle warmtebronnen excl. inductie',
                        3 => 'enkel geschikt voor gas',
                        4 => 'geschikt voor oven'
                    ],
                    'items' => [
                        'incl inductie' => ['filter' => [ 
                            'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                            'count' => false, 
                            'name' => 'alle warmtebronnen incl. inductie'
                        ]],
                        'exclusief inductie' => ['filter' => [ 
                            'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'alle warmtebronnen exclusief inductie'
                        ]],
                        'gas' => ['filter' => [ 
                            'value' => 'item[""] == "ja"',
                            'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'enkel geschikt voor gas'
                        ]],
                        'oven' => ['filter' => [ 
                            'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'geschikt voor oven'
                        ]]
                    ]
                ]
            ],
            //sauteerpannen
            16 => [
                'warmtebron-warmtebron' => [
                    'joins' => [ 
                        1 => 'alle warmtebronnen incl. inductie',
                        2 => 'alle warmtebronnen excl. inductie',
                        3 => 'enkel geschikt voor gas',
                        4 => 'geschikt voor oven'
                    ],
                    'items' => [
                        'incl inductie' => ['filter' => [ 
                            'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                            'count' => false, 
                            'name' => 'alle warmtebronnen incl. inductie'
                        ]],
                        'exclusief inductie' => ['filter' => [ 
                            'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'alle warmtebronnen exclusief inductie'
                        ]],
                        'gas' => ['filter' => [ 
                            'value' => 'item[""] == "ja"',
                            'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'enkel geschikt voor gas'
                        ]],
                        'oven' => ['filter' => [ 
                            'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'geschikt voor oven'
                        ]]
                    ]
                ],
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200 ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '(
                                1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 260
                            ) ', 
                            'count' => false, 
                            'name' => '20 t/m 26cm'
                        ]],
                        'dl3' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 260', 
                            'count' => false, 
                            'name' => '> 26cm'
                        ]]
                    ]
                ],
                'antikleef-antikleef' => [
                    'joins' => [ 1 => 'antikleef'],
                    'items' => [
                        'antikleef1' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'met antikleeflaag'
                        ]],
                        'antikleef2' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'zonder antikleeflaag'
                        ]]
                    ]
                ],
                'vorm' => 'vorm'
            ],
            //pannenkoekpannen
            17 => [
                'warmtebron-warmtebron' => [
                    'joins' => [ 
                        1 => 'alle warmtebronnen incl. inductie',
                        2 => 'alle warmtebronnen excl. inductie',
                        3 => 'enkel geschikt voor gas',
                        4 => 'geschikt voor oven'
                    ],
                    'items' => [
                        'incl inductie' => ['filter' => [ 
                            'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                            'count' => false, 
                            'name' => 'alle warmtebronnen incl. inductie'
                        ]],
                        'exclusief inductie' => ['filter' => [ 
                            'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'alle warmtebronnen exclusief inductie'
                        ]],
                        'gas' => ['filter' => [ 
                            'value' => 'item[""] == "ja"',
                            'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'enkel geschikt voor gas'
                        ]],
                        'oven' => ['filter' => [ 
                            'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'geschikt voor oven'
                        ]]
                    ]
                ],
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200 ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '(
                                1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 260
                            ) ', 
                            'count' => false, 
                            'name' => '20 t/m 26cm'
                        ]],
                        'dl3' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 260', 
                            'count' => false, 
                            'name' => '> 26cm'
                        ]]
                    ]
                ],
                'antikleef-antikleef' => [
                    'joins' => [ 1 => 'antikleef'],
                    'items' => [
                        'antikleef1' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'met antikleeflaag'
                        ]],
                        'antikleef2' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'zonder antikleeflaag'
                        ]]
                    ]
                ]
            ],
            //woks
            20 => [
                'warmtebron-warmtebron' => [
                    'joins' => [ 
                        1 => 'alle warmtebronnen incl. inductie',
                        2 => 'alle warmtebronnen excl. inductie',
                        3 => 'enkel geschikt voor gas',
                        4 => 'geschikt voor oven'
                    ],
                    'items' => [
                        'incl inductie' => ['filter' => [ 
                            'value' => '1_meta.meta_key = "alle warmtebronnen incl. inductie" and  1_meta.meta_value != "" ', 
                            'count' => false, 
                            'name' => 'alle warmtebronnen incl. inductie'
                        ]],
                        'exclusief inductie' => ['filter' => [ 
                            'value' => '2_meta.meta_key = "alle warmtebronnen excl. inductie" and  2_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'alle warmtebronnen exclusief inductie'
                        ]],
                        'gas' => ['filter' => [ 
                            'value' => 'item[""] == "ja"',
                            'value' => '3_meta.meta_key = "enkel geschikt voor gas" and  3_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'enkel geschikt voor gas'
                        ]],
                        'oven' => ['filter' => [ 
                            'value' => '4_meta.meta_key = "geschikt voor oven" and  4_meta.meta_value != "" ',
                            'count' => false, 
                            'name' => 'geschikt voor oven'
                        ]]
                    ]
                ],
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200 ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '(
                                1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 300
                            ) ', 
                            'count' => false, 
                            'name' => '20 t/m 30cm'
                        ]],
                        'dl3' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 300', 
                            'count' => false, 
                            'name' => '> 30cm'
                        ]]
                    ]
                ],
                'antikleef-antikleef' => [
                    'joins' => [ 1 => 'antikleef'],
                    'items' => [
                        'antikleef1' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'met antikleeflaag'
                        ]],
                        'antikleef2' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'zonder antikleeflaag'
                        ]]
                    ]
                ]
            ],
            //ovenschalen en braadsledes
            22 => [
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)', 2 => 'lengte (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value <= 200 and 2_meta.meta_value != 0 )) ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '(
                                (1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200 and 1_meta.meta_value <= 300) 
                                or 
                                ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 200 and 2_meta.meta_value <= 300 and 2_meta.meta_value != 0 )
                            ) ', 
                            'count' => false, 
                            'name' => '20 t/m 30cm'
                        ]],
                        'dl3' => ['filter' => [
                            'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 300) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 300 and 2_meta.meta_value != 0 )) ', 
                            'count' => false, 
                            'name' => '> 30cm'
                        ]]
                    ]
                ],
                'vorm' => 'vorm',
                'Kleur' => 'kleur'
            ],
            //paellapannen
            31 => [
                'diameter/lengte-diameter' => [
                    'joins' => [ 1 => 'diameter (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 400 ', 
                            'count' => false, 
                            'name' => '≤ 40cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 400', 
                            'count' => false, 
                            'name' => '> 40cm'
                        ]]
                    ]
                ],
                'antikleef-antikleef' => [
                    'joins' => [ 1 => 'antikleef'],
                    'items' => [
                        'antikleef1' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'met antikleeflaag'
                        ]],
                        'antikleef2' => ['filter' => [
                            'value' => '1_meta.meta_key = "antikleef" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'zonder antikleeflaag'
                        ]]
                    ]
                ]
            ],
        /**
         * Bakken
         */
        3 => [
            'materiaal' => 'materiaal'
        ],
        /**
         * messen, scharen en snijplanken
         */
        4 => [
            'materiaal' => 'materiaal' 
        ],
            //koksmessen
            45 => [
                 'lemmetlengte-lengte (mm)' => [
                    'joins' => [ 1 => 'lengte (mm)'],
                    'items' => [
                        'dl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "lengte (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 200 ', 
                            'count' => false, 
                            'name' => '≤ 20cm'
                        ]],
                        'dl2' => ['filter' => [
                            'value' => '1_meta.meta_key = "lengte (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200', 
                            'count' => false, 
                            'name' => '> 20cm'
                        ]]
                    ]
                ],
            ],
            //snijplanken en hakblokken
            53 => [
                'hout' => 'Houtsoort',
                'kopshout-kopshout' => [
                    'joins' => [ 1 => 'kopshout', 2 => 'materiaal'],
                    'items' => [
                        'kopshout1' => ['filter' => [
                            'value' => '1_meta.meta_key = "kopshout" and 1_meta.meta_value = "ja" and 2_meta.meta_key = "materiaal" and 2_meta.meta_value = "hout" ', 
                            'count' => false, 
                            'name' => 'ja'
                        ]],
                        'kopshout2' => ['filter' => [
                            'value' => '1_meta.meta_key = "kopshout" and 1_meta.meta_value = "" and 2_meta.meta_key = "materiaal" and 2_meta.meta_value = "hout"', 
                            'count' => false, 
                            'name' => 'nee'
                        ]]
                    ]
                ],
                'sapgeul-met sapgeul' => [
                    'joins' => [ 1 => 'met sapgeul'],
                    'items' => [
                        'sapgeul1' => ['filter' => [
                            'value' => '1_meta.meta_key = "met sapgeul" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'ja'
                        ]],
                        'sapgeul2' => ['filter' => [
                            'value' => '1_meta.meta_key = "met sapgeul" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'nee'
                        ]]
                    ]
                ]
            ],
        /**
         * kookgerei
         */
            //kookhulpen
            56 => [
                'materiaal' => 'materiaal'
            ],
            //mengkommen en maatbekers
            57 => [
                'materiaal' => 'materiaal'
            ],
            //Weegschalen, Timers en Thermometers
                //keukenweegschalen
                136 => [
                     'met afneembare weegbowl-afneembare weegbowl' => [
                        'joins' => [ 1 => 'afneembare weegbowl'],
                        'items' => [
                            'weegbowl1' => ['filter' => [
                                'value' => '1_meta.meta_key = "afneembare weegbowl" and 1_meta.meta_value = "ja" ', 
                                'count' => false, 
                                'name' => 'ja'
                            ]],
                            'weegbowl2' => ['filter' => [
                                'value' => '1_meta.meta_key = "afneembare weegbowl" and 1_meta.meta_value = "" ', 
                                'count' => false, 
                                'name' => 'nee'
                            ]]
                        ]
                    ]
                ],
            //peper en zout
            64 => [
                'materiaal' => 'materiaal',
                'gourmet precision-gourmet precision' => [
                    'joins' => [ 1 => 'gourmet precision'],
                    'items' => [
                        'weegbowl1' => ['filter' => [
                            'value' => '1_meta.meta_key = "gourmet precision" and 1_meta.meta_value = "ja" ', 
                            'count' => false, 
                            'name' => 'ja'
                        ]],
                        'weegbowl2' => ['filter' => [
                            'value' => '1_meta.meta_key = "gourmet precision" and 1_meta.meta_value = "" ', 
                            'count' => false, 
                            'name' => 'nee'
                        ]]
                    ]
                ],
                'Kleur' => 'kleur',
                 'hoogte-hoogte' => [
                    'joins' => [ 1 => 'hoogte (mm)'],
                    'items' => [
                        'hoogte1' => ['filter' => [
                            'value' => '1_meta.meta_key = "hoogte (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 100 ', 
                            'count' => false, 
                            'name' => '≤ 10cm'
                        ]],
                        'hoogte2' => ['filter' => [
                            'value' => '(
                                1_meta.meta_key = "hoogte (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 100 and 1_meta.meta_value <= 200
                            ) ', 
                            'count' => false, 
                            'name' => '10 t/m 20cm'
                        ]],
                        'hoogte3' => ['filter' => [
                            'value' => '1_meta.meta_key = "hoogte (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 200', 
                            'count' => false, 
                            'name' => '> 20cm'
                        ]]
                    ]
                ],
            ],
        /**
         * Bewaren van voeding en keukenorganisatie
         */
            //diepvriesdozen
            1873 => [
                'materiaal' => 'materiaal',
                'Inhoud-inhoud (cl)' => [
                    'joins' => [ 1 => 'inhoud (cl)'],
                    'items' => [
                        'inhoud1' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 100 ', 
                            'count' => false, 
                            'name' => '≤ 1l'
                        ]],
                        'inhoud2' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 100', 
                            'count' => false, 
                            'name' => '> 1l'
                        ]]
                    ]
                ]
            ],
            //voorraaddozen voor droge voeding
            78 => [
                'materiaal' => 'materiaal',
                'Inhoud-inhoud (cl)' => [
                    'joins' => [ 1 => 'inhoud (cl)'],
                    'items' => [
                        'inhoud1' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 100 ', 
                            'count' => false, 
                            'name' => '≤ 1l'
                        ]],
                        'inhoud2' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 100', 
                            'count' => false, 
                            'name' => '> 1l'
                        ]]
                    ]
                ],
                'Kleur' => 'kleur'
            ],
            //hermetisch afsluitende bewaardozen voor verse voeding
            79 => [
                'materiaal' => 'materiaal',
                'inhoud-inhoud (cl)' => [
                    'joins' => [ 1 => 'inhoud (cl)'],
                    'items' => [
                        'inhoud1' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 100 ', 
                            'count' => false, 
                            'name' => '≤ 1l'
                        ]],
                        'inhoud2' => ['filter' => [
                            'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 100', 
                            'count' => false, 
                            'name' => '> 1l'
                        ]]
                    ]
                ]
            ],
            //Broodtrommels
            81 => [
                'materiaal' => 'materiaal',
                'Kleur' => 'kleur'       
            ],
            //isoleerflessen en voedselhouders
            82 => [
                'Kleur' => 'kleur',
            ],
                //isoleerkannen
                148 => [
                    'inhoud-inhoud (cl)1' => [
                        'joins' => [ 1 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 150 ', 
                                'count' => false, 
                                'name' => '≤ 1,5l'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => ' 1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 150', 
                                'count' => false, 
                                'name' => '> 1,5l'
                            ]]
                        ]
                    ]
                ],
                //isoleerkannen met pomp

                //isoleerflessen
                 150 => [
                    'inhoud-inhoud (cl)2' => [
                        'joins' => [ 2 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud3' => ['filter' => [
                                'value' => '2_meta.meta_key = "inhoud (cl)" and 2_meta.meta_value != 0 and 2_meta.meta_value <= 100 ', 
                                'count' => false, 
                                'name' => '≤ 1l'
                            ]],
                            'inhoud4' => ['filter' => [
                                'value' => ' 2_meta.meta_key = "inhoud (cl)" and 2_meta.meta_value != 0 and 2_meta.meta_value > 100', 
                                'count' => false, 
                                'name' => '> 1l'
                            ]]
                        ]
                    ]
                ],
               
                //isolerende voedselhouders
                151 => [
                    'inhoud-inhoud (cl)3' => [
                        'joins' => [ 3 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud5' => ['filter' => [
                                'value' => '3_meta.meta_key = "inhoud (cl)" and 3_meta.meta_value != 0 and 3_meta.meta_value <= 75 ', 
                                'count' => false, 
                                'name' => '≤ 75cl'
                            ]],
                            'inhoud6' => ['filter' => [
                                'value' => ' 3_meta.meta_key = "inhoud (cl)" and 3_meta.meta_value != 0 and 3_meta.meta_value > 75', 
                                'count' => false, 
                                'name' => '> 75cl'
                            ]]
                        ]
                    ]
                ],
            //flessen met hermetische sluitstop
            85 => [
                'inhoud-inhoud (cl)' => [
                        'joins' => [ 1 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 75 ', 
                                'count' => false, 
                                'name' => '≤ 75cl'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => ' 1_meta.meta_key = "inhoud (cl)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 75', 
                                'count' => false, 
                                'name' => '> 75cl'
                            ]]
                        ]
                    ]
            ],
            //inmaakbokalen en confituurpo1tten
                //inmaakbokalen
                9365 => [
                    'Inhoud-inhoud (cl)' => [
                        'joins' => [ 1 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value <= 50 ', 
                                'count' => false, 
                                'name' => '≤ 0,5l'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and ( 1_meta.meta_value > 50 && 1_meta.meta_value <= 100 )', 
                                'count' => false, 
                                'name' => '0,5 t/m 1l'
                            ]],
                            'inhoud3' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value > 100 ', 
                                'count' => false, 
                                'name' => '> 1l'
                            ]]
                        ]
                    ]
                ],
                //inmaakflessen
                9368 => [
                    'Inhoud-inhoud (cl)' => [
                        'joins' => [ 2 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud4' => ['filter' => [
                                'value' => '2_meta.meta_key = "inhoud (cl)" and  2_meta.meta_value <= 50 ', 
                                'count' => false, 
                                'name' => '≤ 0,5l'
                            ]],
                            'inhoud5' => ['filter' => [
                                'value' => '2_meta.meta_key = "inhoud (cl)" and ( 2_meta.meta_value > 50 && 2_meta.meta_value <= 100 )', 
                                'count' => false, 
                                'name' => '0,5 t/m 1l'
                            ]],
                            'inhoud6' => ['filter' => [
                                'value' => '2_meta.meta_key = "inhoud (cl)" and  2_meta.meta_value > 100 ', 
                                'count' => false, 
                                'name' => '> 1l'
                            ]]
                        ]
                    ]
                ],
        //Tafel
            //Glazen
            94 => [
                'materiaal' => 'Materiaal',
                'Kleur' => 'kleur'
            ],
            //Serviesgoed
             95 => [
                'materiaal' => 'Materiaal',
                'Kleur' => 'kleur'
            ],
                //Platte borden
                170 => [
                    'diameter/lengte-diameter' => [
                        'joins' => [ 1 => 'diameter (mm)', 2 => 'lengte (mm)'],
                        'items' => [
                            'dl1' => ['filter' => [
                                'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value <= 150) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value <= 150 and 2_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '≤ 15cm'
                            ]],
                            'dl2' => ['filter' => [
                                'value' => '(
                                    (1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 150 and 1_meta.meta_value <= 230) 
                                    or 
                                    ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 150 and 2_meta.meta_value <= 230 and 2_meta.meta_value != 0 )
                                ) ', 
                                'count' => false, 
                                'name' => '15 t/m 23cm'
                            ]],
                            'dl3' => ['filter' => [
                                'value' => '((1_meta.meta_key = "diameter (mm)" and 1_meta.meta_value != 0 and 1_meta.meta_value > 230) or ( 2_meta.meta_key = "lengte (mm)" and 2_meta.meta_value > 230 and 2_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '> 23cm'
                            ]]
                        ]
                    ],
                     'vorm' => 'vorm',
                    'Organisch-organische vorm' => [
                        'joins' => [ 3 => 'organische vorm'],
                        'items' => [
                            'organisch1' => ['filter' => [
                                'value' => ' 3_meta.meta_key = "organische vorm" and 3_meta.meta_value = "ja" ', 
                                'count' => false, 
                                'name' => 'ja'
                            ]],
                            'organisch2' => ['filter' => [
                                'value' => ' 3_meta.meta_key = "organische vorm" and 3_meta.meta_value = "" ', 
                                'count' => false, 
                                'name' => 'nee'
                            ]]
                        ]
                    ]
                ],
                //Koppen, schotels en mugs
                175 => [
                    'inhoud-inhoud (cl)1' => [
                        'joins' => [ 4 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '4_meta.meta_key = "inhoud (cl)" and 4_meta.meta_value != 0 and 4_meta.meta_value <= 15 ', 
                                'count' => false, 
                                'name' => '≤ 15cl'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => ' 4_meta.meta_key = "inhoud (cl)" and 4_meta.meta_value != 0 and 4_meta.meta_value > 15', 
                                'count' => false, 
                                'name' => '> 15cl'
                            ]]
                        ]
                    ]
                ],
                // //amuseglazen
                179 => [
                    'inhoud-inhoud (cl)1' => [
                        'joins' => [ 5 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '5_meta.meta_key = "inhoud (cl)" and 5_meta.meta_value != 0 and 5_meta.meta_value <= 10 ', 
                                'count' => false, 
                                'name' => '≤ 10cl'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => ' 5_meta.meta_key = "inhoud (cl)" and 5_meta.meta_value != 0 and 5_meta.meta_value > 10', 
                                'count' => false, 
                                'name' => '> 10cl'
                            ]]
                        ]
                    ]
                ],
                //Schalen, kommen en schotels
                181 => [
                    'diameter/lengte-diameter' => [
                        'joins' => [ 6 => 'diameter (mm)', 7 => 'lengte (mm)'],
                        'items' => [
                            'dl4' => ['filter' => [
                                'value' => '((6_meta.meta_key = "diameter (mm)" and 6_meta.meta_value != 0 and 6_meta.meta_value <= 100) or ( 7_meta.meta_key = "lengte (mm)" and 7_meta.meta_value <= 100 and 7_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '≤ 10cm'
                            ]],
                            'dl5' => ['filter' => [
                                'value' => '(
                                    (6_meta.meta_key = "diameter (mm)" and 6_meta.meta_value != 0 and 6_meta.meta_value > 100 and 6_meta.meta_value <= 250) 
                                    or 
                                    ( 7_meta.meta_key = "lengte (mm)" and 7_meta.meta_value > 100 and 7_meta.meta_value <= 250 and 7_meta.meta_value != 0 )
                                ) ', 
                                'count' => false, 
                                'name' => '10 t/m 25cm'
                            ]],
                            'dl6' => ['filter' => [
                                'value' => '((6_meta.meta_key = "diameter (mm)" and 6_meta.meta_value != 0 and 6_meta.meta_value > 250) or ( 7_meta.meta_key = "lengte (mm)" and 7_meta.meta_value > 250 and 7_meta.meta_value != 0 )) ', 
                                'count' => false, 
                                'name' => '> 25cm'
                            ]]
                        ]
                    ],
                    'vorm' => 'Vorm',
                    'Organisch-organische vorm' => [
                        'joins' => [ 8 => 'organische vorm'],
                        'items' => [
                            'organisch3' => ['filter' => [
                                'value' => ' 8_meta.meta_key = "organische vorm" and 8_meta.meta_value = "ja" ', 
                                'count' => false, 
                                'name' => 'ja'
                            ]],
                            'organisch4' => ['filter' => [
                                'value' => ' 8_meta.meta_key = "organische vorm" and 8_meta.meta_value = "" ', 
                                'count' => false, 
                                'name' => 'nee'
                            ]]
                        ]
                    ]
                ],
            //Bestek
            96 => [
                'materiaal' => 'materiaal',
                'dikte staal mm' => 'dikte staal mm',
                'afwerking' => 'afwerking'
            ],  
                // //Messen
                // 186 => [
                //     'afwerking-afwerking' => [
                //         'joins' => [ 1 => 'afwerking'],
                //         'items' => [
                //             'afwerking1' => ['filter' => [
                //                 'value' => ' 1_meta.meta_key = "afwerking" and 1_meta.meta_value = "getand" ', 
                //                 'count' => false, 
                //                 'name' => 'ja'
                //             ]],
                //             'afwerking2' => ['filter' => [
                //                 'value' => ' 1_meta.meta_key = "afwerking" and 1_meta.meta_value != "getand" ', 
                //                 'count' => false, 
                //                 'name' => 'nee'
                //             ]]
                //         ]
                //     ]
                // ],
            //tafelaccessoires
                //Placemats
                195 => [
                    'Kleur' => 'kleur'
                ],
                //papieren servetten
                196 => [
                     'breedte/lengte-breedte' => [
                        'joins' => [ 2 => 'breedte (mm)', 3 => 'lengte (mm)'],
                        'items' => [
                            'bl4' => ['filter' => [
                                'value' => '(2_meta.meta_key = "breedte (mm)" and 2_meta.meta_value = 250 and 3_meta.meta_key = "lengte (mm)" and 3_meta.meta_value = 250  )', 
                                'count' => false, 
                                'name' => '25x25cm'
                            ]],
                            'bl2' => ['filter' => [
                                'value' => '(2_meta.meta_key = "breedte (mm)" and 2_meta.meta_value = 330 and 3_meta.meta_key = "lengte (mm)" and 3_meta.meta_value = 330  ) ', 
                                'count' => false, 
                                'name' => '33x33cm'
                            ]]
                        ]
                    ]
                ],
            //Dienbladen
            98 => [
                'materiaal' => 'materiaal'
            ],
        //Bar wijn glazen
            //Bar & wijn
                //Glazen
                211 => [
                    'Kleur' => 'kleur'
                ],
            //Waterfilters 
            100 => [
                'Kleur' => 'kleur'
            ],
        //Huishoud
            //Afval 
             102 => [
                'Kleur' => 'kleur',
                'Inhoud-inhoud (cl)' => [
                        'joins' => [ 1 => 'inhoud (cl)'],
                        'items' => [
                            'inhoud1' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value <= 1000 ', 
                                'count' => false, 
                                'name' => '≤ 10l'
                            ]],
                            'inhoud2' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and ( 1_meta.meta_value > 1000 && 1_meta.meta_value <= 2000 )', 
                                'count' => false, 
                                'name' => '10 t/m 20l'
                            ]],
                            'inhoud3' => ['filter' => [
                                'value' => '1_meta.meta_key = "inhoud (cl)" and  1_meta.meta_value > 2000 ', 
                                'count' => false, 
                                'name' => '> 20l'
                            ]]
                        ]
                    ]
            ], 
            //Ladder en opsatpjes
            103 => [
                'aantal treden' => 'Aantal treden'
            ], 
            //Textiel
             105 => [
                'Kleur' => 'kleur',
            ],
            //Badkamer
                //Sanitairemmers
                247  => [
                'Kleur' => 'kleur',
            ]



        
        
       
       
        
    ),

    'um-email' => [
        'welcome_email_sub' => [
            'nl' => 'Welkom bij Muller!',
            'fr' => 'Bienvenue à Muller!', 
            'en' => 'Welcome to Muller!'
        ], 
        'welcome_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Bedankt voor uw registratie op {site_name}. Uw account is nu actief.

U kunt inloggen via deze  url:

{login_url}

Uw account e-mail: {email}
Uw account gebruikersnaam: {username}

Indien u problemen of vragen hebt, kan u ons contacteren via {admin_email}

Alvast bedankt,
Het Muller team
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Merci de vous être inscrit à {site_name}. Votre compte est maintenant actif.

Pour vous connecter s\'il vous plaît visitez l\'adresse suivante:

{login_url}

Votre adresse e-mail de votre compte: {email}
Nom d\'utilisateur de votre compte: {nom d\'utilisateur}

Si vous avez des problèmes, contactez-nous à l\'adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

Thank you for signing up with {site_name}. Your account is now active.

To login please visit the following url:

{login_url}

Your account e-mail: {email}
Your account username: {username}

If you have any problems, please contact us at {admin_email}

Thanks,
{site_name}'
        ], 
        'checkmail_email_sub' => [
            'nl' => 'Gelieve uw account te activeren',
            'fr' => 'Veuillez activer votre compte', 
            'en' => 'Please activate your account'
        ], 
        'checkmail_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Bedankt voor uw registratie op {site_name}. Om uw account te activeren klikt u op de link hieronder om uw e-mail adres te bevestigen:

{account_activation_link}

Indien u problemen of vragen hebt, kan u ons contacteren via {admin_email}

Bedankt,
Het Muller team
{site_name}',
            'fr' => 'onjour {Aanspreking} {last_name},

Merci de vous être inscrit à {site_name}. Pour activer votre compte, veuillez cliquer sur le lien ci-dessous pour confirmer votre adresse e-mail:

{account_activation_link}

Si vous avez des problèmes, contactez-nous à l\'adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

Thank you for signing up with {site_name}. To activate your account, please click the link below to confirm your email address:

{account_activation_link}

If you have any problems, please contact us at {admin_email}

Thanks,
{site_name}'
        ],
        'pending_email_sub' => [
            'nl' => 'Uw aanvraag is in behandeling',
            'fr' => 'Votre compte est en attente d\'examen', 
            'en' => 'Your account is pending review'
        ],
        'pending_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Bedankt voor uw registratie op {site_name}. Uw aanvraag voor een account is in behandeling.
U ontvangt zo spoedig mogelijk een bevestiging per mail.

Indien u problemen of vragen hebt, kan u ons contacteren via {admin_email}

Bedankt,
Het Muller team
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Merci de vous être inscrit à la zone client de notre site.
Votre compte est présentement en attente d’approbation.
Une fois votre compte approuvé, vous recevrez un courriel de confirmation à l’adresse e-mail que vous avez indiquée durant la procédure d’inscription.

Si vous avez des problèmes, n’hésitez pas à nous contacter à l’adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

Thank you for signing up with {site_name}. Your account is currently being reviewed by a member of our team. You will receive an email to let you know whether your application has been approved.

If you have any problems, please contact us at {admin_email}

Thanks,
{site_name}'
        ], 
        'approved_email_sub' => [
            'nl' => 'Uw account op {site_name} is nu actief',
            'fr' => 'Votre compte sur {site_name} est maintenant actif', 
            'en' => 'Your account at {site_name} is now active'
        ],
        'approved_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Bedankt voor uw registratie op {site_name}. Uw aanvraag is goedgekeurd en is nu actief.

Inloggen kunt u via de volgende url.

Stel uw paswoord in:
{password_reset_link}

Bij problemen kan u ons contacteren via {admin_email}

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Merci de vous être inscrit à Muller kitchen and tableware. Votre compte est maintenant activé.

Vous pouvez vous connecter à partir de l’adresse suivante.
Définissez le mot de passe de votre code utilisateur:

{password_reset_link}

Si vous avez des problèmes, n’hésitez pas à nous contacter à l’adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

Thank you for signing up with {site_name}. Your account has been approved and is now active.

To login please visit the following url.

Set your account password:
{password_reset_link}

If you have any problems, please contact us at {admin_email}

Thanks,
{site_name}'
        ],
        'rejected_email_sub' => [
            'nl' => 'Uw aanvraag is geweigerd',
            'fr' => 'Votre compte a été rejeté', 
            'en' => 'Your account has been rejected'
        ],
        'rejected_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Bedankt voor uw registratie op {site_name}. Het is echter niet mogelijk om een account te activeren op onze site. 

U kan ons contacteren via {admin_email} indien u hier vragen bij heeft.

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Merci de votre demande de compte sur {site_name}. Nous avons examiné vos informations et nous ne pouvons malheureusement pas accepter votre demande pour le moment.

N\'hésitez pas à postuler à une date ultérieure.

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

Thank you for your request for an account on {site_name}. We have reviewed your information and unfortunately we are unable to accept your request at this moment.

Please feel free to apply again at a future date.

Thanks,
{site_name}'
        ],
        'inactive_email_sub' => [
            'nl' => 'Uw account is tijdelijk gedeactiveerd',
            'fr' => 'Votre compte a été désactivé', 
            'en' => 'Your account has been deactivated'
        ],
        'inactive_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Dit is een automatische mail om u op de hoogte te brengen dat uw account op {site_name} tijdelijk gedeactiveerd is.

Indien u uw account opnieuw wil laten activeren, kan u ons mailen op {admin_email}

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Ceci est un email automatisé pour vous informer que votre compte {site_name} a été désactivé.

Si vous souhaitez réactiver votre compte, contactez-nous à l\'adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

This is an automated email to let you know your {site_name} account has been deactivated.

If you would like your account to be reactivated please contact us at {admin_email}

Thanks,
{site_name}'
        ],
        'deletion_email_sub' => [
            'nl' => 'Uw account is verwijderd',
            'fr' => 'Votre compte a été supprimé', 
            'en' => 'Your account has been deleted'
        ],
        'deletion_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

Dit is een automatische mail om u op de hoogte te brengen dat uw account op {site_name} verwijderd is. Al uw persoonlijke gegevens op de site zijn verwijderd en u kan niet langer inloggen op {site_name}.

Mocht dit een vergissing zijn, of indien u hier vragen bij heeft, kan u ons contacteren op {admin_email}

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Ceci est un email automatisé pour vous informer que votre compte {site_name} a été supprimé. Toutes vos informations personnelles ont été définitivement supprimées et vous ne pourrez plus vous connecter à {site_name}.

Si votre compte a été supprimé par accident, contactez-nous à l\'adresse {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

This is an automated email to let you know your {site_name} account has been deleted. All of your personal information has been permanently deleted and you will no longer be able to login to {site_name}.

If your account has been deleted by accident please contact us at {admin_email}

Thanks,
{site_name}'
        ],
        'resetpw_email_sub' => [
            'nl' => 'Uw wachtwoord opnieuw instellen',
            'fr' => 'Réinitialisez votre mot de passe', 
            'en' => 'Reset your password'
        ],
        'resetpw_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

We hebben een aanvraag ontvangen om uw wachtwoord opnieuw in te stellen. Indien u dit aangevraagd heeft, kan u uw wachtwoord instellen via:

{password_reset_link}

Indien u deze aanvraag niet gedaan hebt, kan u deze mail negeren.

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Nous avons reçu une demande de réinitialisation du mot de passe pour votre compte. Si vous avez fait cette demande, cliquez sur le lien ci-dessous pour changer votre mot de passe:

{password_reset_link}

Si vous n\'avez pas fait cette demande, vous pouvez ignorer cet e-mail

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

We received a request to reset the password for your account. If you made this request, click the link below to change your password:

{password_reset_link}

If you didn\'t make this request, you can ignore this email

Thanks,
{site_name}'
        ],
        'changedpw_email_sub' => [
            'nl' => 'Uw wachtwoord op {site_name} is gewijzigd',
            'fr' => 'Votre mot de passe {site_name} a été modifié', 
            'en' => 'Your {site_name} password has been changed'
        ],
        'changedpw_email' => [
            'nl' => 'Beste {Aanspreking} {last_name},

U hebt recent uw wachtwoord op {site_name} opnieuw ingesteld.

Indien u uw wachtwoord niet opnieuw heeft ingesteld is uw account mogelijk niet meer veilig en kan u ons best contacteren via: {admin_email}

Bedankt,
{site_name}',
            'fr' => 'Bonjour {Aanspreking} {last_name},

Vous avez récemment modifié le mot de passe associé à votre compte {site_name}.

Si vous n\'avez pas effectué cette modification et pensez que votre compte {site_name} a été compromis, veuillez nous contacter à l\'adresse e-mail suivante: {admin_email}

Merci,
L’équipe Muller', 
            'en' => 'Hi {Aanspreking} {last_name},

You recently changed the password associated with your {site_name} account.

If you did not make this change and believe your {site_name} account has been compromised, please contact us at the following email address: {admin_email}

Thanks,
{site_name}'
        ],
    ]
    
);