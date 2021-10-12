<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Controller;

use JsonException;
use OliverThiele\OtFaq\Domain\Repository\QuestionRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *  (c) 2020-2021 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 ***/

/**
 * QuestionController
 */
class QuestionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * questionRepository
     *
     * @var QuestionRepository|null
     */
    protected ?QuestionRepository $questionRepository = null;

    /**
     * @param  QuestionRepository  $questionRepository
     */
    public function injectQuestionRepository(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * action list
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function listAction(): ResponseInterface
    {
        $questions = $this->questionRepository->findAll();
        $this->view->assign('questions', $questions);

        $questionArray = [];

        /** @var \OliverThiele\OtFaq\Domain\Model\Question $question */
        foreach ($questions as $question) {
            $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);

            $conf = [
                'parameter' => $question->getLink(),
                'useCashHash' => false,
                'forceAbsoluteUrl' => true
            ];
            $link = $cObj->typoLink('Mehr zu dieser FAQ', $conf);

            $questionArray[] = [
                '@type' => 'Question',
                'name' => $question->getQuestion(),
                'acceptedAnswer' => [
                    '@type' => 'answer',
                    'text' => $question->getAnswer().'<p>'.$link.'</p>'
                ]
            ];
        }
        $array = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questionArray
        ];
        $json = json_encode($array, JSON_THROW_ON_ERROR);
        $this->view->assign('json', $json);

        // Wrong error message "Replace calls to `getContentObject()` with `getContentObjectRenderer()`." in extension scanner!
        $currentContentObject = $this->configurationManager->getContentObject()->data;
        $this->view->assign('data', $currentContentObject);

        return $this->responseFactory->createResponse()
            ->withAddedHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
