<?php
/**
 * Created by PhpStorm.
 * User: Patsay Sergey
 * Date: 22.05.2017
 * Time: 19:59
 */

namespace Netcast\Urest\MainBundle\Entity;


class BlogPostContent extends IsI18NEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $preview_text;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogPostContent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }


    /**
     * Set content
     *
     * @param string $content
     * @return BlogPostContent
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set preview_text
     *
     * @param string $previewText
     * @return BlogPostContent
     */
    public function setPreviewText($previewText)
    {
        $this->preview_text = $previewText;

        return $this;
    }

    /**
     * Get preview_text
     *
     * @return string
     */
    public function getPreviewText()
    {
        return $this->preview_text;
    }
}