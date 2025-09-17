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
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Finds and retrieves all records based on the specified criteria.
     *
     * @param array<int>|null $pages Optional array of page IDs to filter the query by specific storage pages.
     * @return QueryResultInterface The result of the query execution containing the retrieved records.
     */
    public function findAll(?array $pages = null): QueryResultInterface
    {
        $query = $this->createQuery();
        if ($pages !== null) {
            $query->getQuerySettings()->setStoragePageIds($pages);
        }
        return $query->execute();
    }

}
