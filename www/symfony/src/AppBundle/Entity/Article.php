<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArticleRepository")
 */
class Article
{
    const SPANISH_LANGUAGE = 1;
    const ENGLISH_LANGUAGE = 2;
    const BOTH_LANGUAGE = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="language", type="smallint")
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string", length=2000)
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_alt", type="string", length=255, nullable=true)
     */
    private $thumbnailAlt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="ArticleExtend", mappedBy="article")
     */
    private $article_extend;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @ORM\JoinTable(name="ArticleTag")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private $comments;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set active.
     *
     * @param string $active
     *
     * @return Aricle
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set language.
     *
     * @param int $language
     *
     * @return Article
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set summary.
     *
     * @param string $summary
     *
     * @return Article
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary.
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set thumbnail.
     *
     * @param string $thumbnail
     *
     * @return Article
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail.
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set thumbnailAlt.
     *
     * @param string $thumbnailAlt
     *
     * @return Article
     */
    public function setThumbnailAlt($thumbnailAlt)
    {
        $this->thumbnailAlt = $thumbnailAlt;

        return $this;
    }

    /**
     * Get thumbnailAlt.
     *
     * @return string
     */
    public function getThumbnailAlt()
    {
        return $this->thumbnailAlt;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setArticleExtend(ArticleExtend $article_extend)
    {
        $this->article_extend = $article_extend;
    }

    public function getArticleExtend()
    {
        return $this->article_extend;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }
}
