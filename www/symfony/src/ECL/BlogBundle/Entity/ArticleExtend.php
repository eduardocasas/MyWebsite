<?php

namespace ECL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ECL\BlogBundle\Entity\Article;

/**
 * ArticleExtend
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ECL\BlogBundle\Entity\ArticleExtendRepository")
 */
class ArticleExtend
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

   /**
     * @ORM\OneToOne(targetEntity="Article", inversedBy="article_extend")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;
    
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle()
    {
        return $this->article;
    }

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
     * Set content
     *
     * @param string $content
     * @return ArticleExtend
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
}
