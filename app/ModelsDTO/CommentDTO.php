<?php

namespace App\ModelsDTO;

use Carbon\Carbon;

/**
 * Class NewCommentDTO
 * @package App\ModelsDTO
 */
class CommentDTO
{
    /**
     * @var Carbon
     */
    private Carbon $date;
    /**
     * @var string
     */
    private string $articleSlug;
    /**
     * @var string
     */
    private string $subject;
    /**
     * @var string
     */
    private string $body;

    /**
     * CommentDTO constructor.
     * @param int $article_id
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $articleSlug, string $subject, string $body)
    {
        $this->articleSlug = $articleSlug;
        $this->subject = $subject;
        $this->body = $body;
        $this->date = Carbon::now();
    }

    /**
     * @return string
     */
    public function getArticleSlug(): string
    {
        return $this->articleSlug;
    }

    /**
     * @param string $articleSlug
     */
    public function setArticleSlug(string $articleSlug): void
    {
        $this->articleSlug = $articleSlug;
    }


    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
