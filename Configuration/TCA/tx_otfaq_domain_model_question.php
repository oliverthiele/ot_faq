<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question',
        'label' => 'question',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'question',
        'iconfile' => 'EXT:ot_faq/Resources/Public/Icons/question.svg'
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource,
         question, answer, link, related_questions, tags,
         --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access, ,
         --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories, categories'
        ],
    ],
    'palettes' => [
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => 'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel, --linebreak--,editlock'
        ],
        'hidden' => [
            'showitem' => 'hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden'
        ]
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_otfaq_domain_model_question',
                'foreign_table_where' => 'AND {#tx_otfaq_domain_model_question}.{#pid}=###CURRENT_PID### AND {#tx_otfaq_domain_model_question}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'question' => [
            'exclude' => false,
            'label' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.question',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'eval' => 'trim,required'
            ],
        ],
        'answer' => [
            'exclude' => false,
            'label' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.answer',
            'description' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.answer.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'link' => [
            'exclude' => false,
            'label' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.link',
            'description' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.link.description',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
            ]
        ],
        'related_questions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.related_questions',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_otfaq_domain_model_question',
                'MM' => 'tx_otfaq_question_question_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],

        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ot_faq/Resources/Private/Language/locallang_db.xlf:tx_otfaq_domain_model_question.tags',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_otfaq_domain_model_tag',
                'MM' => 'tx_otfaq_question_tag_mm',
                'foreign_table' => 'tx_otfaq_domain_model_tag',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
                'suggestOptions' => [
                    'default' => [
                        'additionalSearchFields' => 'tag',
//                        'addWhere' => 'AND pages.doktype = 1'
                    ]
                ]
            ],
        ],
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.categories',
            'config' => [
                'type' => 'category'
            ]
        ]
    ],
];
