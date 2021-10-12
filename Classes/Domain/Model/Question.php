<?php

declare(strict_types=1);

namespace OliverThiele\OtFaq\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***
 *
 * This file is part of the "FAQ" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020-2021 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 *
 ***/

/**
 * Question
 */
class Question extends AbstractEntity
{

    /**
     * The question
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $question = '';

    /**
     * The answer
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $answer = '';

    /**
     * Related Questions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Question>
     */
    protected $relatedQuestions = null;

    /**
     * Tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Tag>
     * @Extbase\ORM\Lazy
     */
    protected $tags = null;

    /**
     * Link
     *
     * @var string
     */
    protected $link = '';

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     *
     * @return void
     */
    protected function initStorageObjects(): void
    {
        $this->answers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->relatedQuestions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the question
     *
     * @return string $question
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * Sets the question
     *
     * @param  string  $question
     * @return void
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * Adds a Question
     *
     * @param  \OliverThiele\OtFaq\Domain\Model\Question  $relatedQuestion
     * @return void
     */
    public function addRelatedQuestion(Question $relatedQuestion): void
    {
        $this->relatedQuestions->attach($relatedQuestion);
    }

    /**
     * Removes a Question
     *
     * @param  \OliverThiele\OtFaq\Domain\Model\Question  $relatedQuestionToRemove  The Question to be removed
     * @return void
     */
    public function removeRelatedQuestion(Question $relatedQuestionToRemove): void
    {
        $this->relatedQuestions->detach($relatedQuestionToRemove);
    }

    /**
     * Returns the relatedQuestions
     *
     * @return ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Question>||null $relatedQuestions
     */
    public function getRelatedQuestions()
    {
        return $this->relatedQuestions;
    }

    /**
     * Sets the relatedQuestions
     *
     * @param  ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Question>  $relatedQuestions
     * @return void
     */
    public function setRelatedQuestions(ObjectStorage $relatedQuestions): void
    {
        $this->relatedQuestions = $relatedQuestions;
    }

    /**
     * Adds a Tag
     *
     * @param  Tag  $tag
     * @return void
     */
    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param  Tag  $tagToRemove  The Tag to be removed
     * @return void
     */
    public function removeTag(Tag $tagToRemove): void
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the tags
     *
     * @return ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Tag>||null $tags
     */
    public function getTags(): ?ObjectStorage
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param  ObjectStorage<\OliverThiele\OtFaq\Domain\Model\Tag>  $tags
     * @return void
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @param  string  $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param  string  $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

}
