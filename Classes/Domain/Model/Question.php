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
 *  (c) 2020-2023 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
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
    protected string $question = '';

    /**
     * The answer
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected string $answer = '';

    /**
     * Related Questions
     *
     * @var ObjectStorage<Question>
     */
    protected ObjectStorage $relatedQuestions;

    /**
     * Tags
     *
     * @var ObjectStorage<Tag>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $tags;

    /**
     * Link
     *
     * @var string
     */
    protected string $link = '';

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     */
    protected function initStorageObjects(): void
    {
        $this->relatedQuestions = new ObjectStorage();
        $this->tags = new ObjectStorage();
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
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * Adds a Question
     */
    public function addRelatedQuestion(Question $relatedQuestion): void
    {
        $this->relatedQuestions->attach($relatedQuestion);
    }

    /**
     * Removes a Question
     *
     * @param Question $relatedQuestionToRemove The Question to be removed
     */
    public function removeRelatedQuestion(Question $relatedQuestionToRemove): void
    {
        $this->relatedQuestions->detach($relatedQuestionToRemove);
    }

    /**
     * Returns the relatedQuestions
     *
     * @return ObjectStorage<Question>|null $relatedQuestions
     */
    public function getRelatedQuestions(): ?ObjectStorage
    {
        return $this->relatedQuestions;
    }

    /**
     * Sets the relatedQuestions
     *
     * @param ObjectStorage<Question> $relatedQuestions
     */
    public function setRelatedQuestions(ObjectStorage $relatedQuestions): void
    {
        $this->relatedQuestions = $relatedQuestions;
    }

    /**
     * Adds a Tag
     */
    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param Tag $tagToRemove The Tag to be removed
     */
    public function removeTag(Tag $tagToRemove): void
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the tags
     *
     * @return ObjectStorage|null $tags
     */
    public function getTags(): ?ObjectStorage
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param ObjectStorage<Tag> $tags
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}
