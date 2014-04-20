<?php

namespace ECL\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends EntityRepository
{
    
    public function getAllOrderByArticle()
    {
        $dql = "SELECT t.name, t.slug, a.id
        FROM ECLBlogBundle:Tag t
        JOIN t.articles a";
        $query = $this->getEntityManager()->createQuery($dql);
        $collection = array();
        foreach ($query->getResult() as $item) {
            $collection[$item['id']][] = $item;
        }
        
        return $collection;
    }
    
    public function getByArticle($article_id)
    {
        $dql = "SELECT t.name, t.slug
        FROM ECLBlogBundle:Tag t
        JOIN t.articles a
        WHERE a.id = :article_id";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('article_id', $article_id);

        return $query->getResult();
    }
    
    public function getNameBySlug($tag_slug)
    {
        $dql = "SELECT t.name
        FROM ECLBlogBundle:Tag t
        WHERE t.slug = :slug";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('slug', $tag_slug);

        return $query->getSingleScalarResult();
    }
    
}