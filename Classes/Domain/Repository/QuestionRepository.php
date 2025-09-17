<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***
 *
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020-2025 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 *
 ***/

/**
 * The repository for Questions
 */
class QuestionRepository extends Repository
{
    /**
     * @var array<non-empty-string, QueryInterface::ORDER_*>
     */
    protected $defaultOrderings = [
        // todo If the FAQ is read from different pages, sorting does not fit.
        //        'pid' => QueryInterface::ORDER_DESCENDING,
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Returns all objects of this repository.
     *
     * @param array<int>|null $pages
     * @return QueryResultInterface
     */
    public function findAll(?array $pages = null): QueryResultInterface
    {
        $query = $this->createQuery();
        $querySettings = $query->getQuerySettings();

        if ($pages !== null) {
            $querySettings->setStoragePageIds($pages);
        } else {
            $currentPid = (int)$GLOBALS['TSFE']->id;
            $querySettings->setStoragePageIds([$currentPid]);
        }

        $this->setDefaultQuerySettings($querySettings);

        return $query->execute();
    }
}
