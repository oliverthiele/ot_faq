<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'FAQ',
    'description' => 'FAQ extension with output of structured data in JSON format.',
    'category' => 'plugin',
    'author' => 'Oliver Thiele',
    'author_email' => 'mail@oliver-thiele.de',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.4',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.1-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
