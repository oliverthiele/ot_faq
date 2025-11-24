<?php

declare(strict_types=1);

/**
 * Copyright notice
 *
 * (c) 2025 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 * All rights reserved
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 */

namespace OliverThiele\OtFaq\Domain\Repository;

use OliverThiele\OtFaq\Domain\Model\Question;
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
 *
 * @extends Repository<Question>
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
     * @return QueryResultInterface<int, Question> The result of the query execution containing the retrieved records.
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
