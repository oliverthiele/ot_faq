<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'FAQ',
    'description' => 'FAQ extension with output of structured data in JSON format.',
    'category' => 'plugin',
    'author' => 'Oliver Thiele',
    'author_email' => 'mail@oliver-thiele.de',
    'state' => 'stable',
    'version' => '3.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.21-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
