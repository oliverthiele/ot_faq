<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Controller;

use JsonException;
use OliverThiele\OtFaq\Domain\Model\Question;
use OliverThiele\OtFaq\Domain\Repository\QuestionRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *  (c) 2020-2024 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 ***/

/**
 * QuestionController
 */
class QuestionController extends ActionController
{
    public function __construct(protected QuestionRepository $questionRepository, protected ContentObjectRenderer $cObj)
    {
    }

    /**
     * action list
     *
     * @throws JsonException
     */
    public function listAction(): ResponseInterface
    {
        $currentContentObject = null;
        if ($this->request->getAttribute('currentContentObject') !== null) {
            $currentContentObject = $this->request->getAttribute('currentContentObject')->data;
        }
        $this->view->assign('data', $currentContentObject);

        $pages = null;
        if (!isset($currentContentObject['pages']) || $currentContentObject['pages'] === '') {
            $questions = $this->questionRepository->findAll();
        } else {
            $pagesArray = explode(',', (string)$currentContentObject['pages']);
            foreach ($pagesArray as $page) {
                $pages[] = (int)$page;
            }
            $questions = $this->questionRepository->findAll($pages);
        }

        $this->view->assign('questions', $questions);

        $questionArray = [];

        /** @var Question $question */
        foreach ($questions as $question) {
            $conf = [
                'parameter' => $question->getLink(),
                'useCashHash' => false,
                'forceAbsoluteUrl' => true,
            ];

            $link = '';
            if ($conf['parameter'] !== '') {
                $label = (string)LocalizationUtility::translate(
                    'button.more.json',
                    'OtFaq'
                );
                $link = '<p>' . $this->cObj->typoLink($label, $conf) . '</p>';
            }

            $questionArray[] = [
                '@type' => 'Question',
                'name' => $question->getQuestion(),
                'acceptedAnswer' => [
                    '@type' => 'answer',
                    'text' => $question->getAnswer() . $link,
                ],
            ];
        }
        $array = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questionArray,
        ];
        $json = json_encode($array, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        $this->view->assign('json', $json);

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
