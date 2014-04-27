<?php
namespace ECL\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ECL\BlogBundle\Entity\Article;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    
    public function getCollectionByPageTagLanguage($language, $tag = null, $limit = null, $page = null)
    {
        $dql = "SELECT a.id,a.title,a.slug,a.date,a.thumbnail,a.thumbnailAlt,a.summary,
        CASE WHEN (a.language = ".Article::SPANISH_LANGUAGE." OR a.language = ".Article::BOTH_LANGUAGE.") THEN 'es' ELSE 'en' as html_language
        FROM ECLBlogBundle:Article a
        JOIN a.tags t
        WHERE a.active = 1 AND (a.language = :both_language OR a.language = :user_language)";
        if ($tag !== null) {
            $dql .= ' AND t.slug=:tag_slug';
        }
        $dql .= '  GROUP BY a.id ORDER BY a.id DESC';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('both_language', Article::BOTH_LANGUAGE);
        $query->setParameter('user_language', $this->getLanguageId($language));
        if ($tag !== null) {
            $query->setParameter('tag_slug', $tag);
        }
        if ($limit !== null) {
            $query->setMaxResults($limit);
        }
        if ($page !== null) {
            $query->setFirstResult(($page-1)*$limit);
        }
        $collection = $query->getResult();
        $tags = $this->getEntityManager()->getRepository('ECLBlogBundle:Tag')->getAllOrderByArticle();
                
        foreach ($collection as &$article) {
            $article['tags'] = $tags[$article['id']];
        }

        return $collection;
    }
    
    public function getArticleByDateAndSlug($date, $slug)
    {
        list ($day, $month, $year) = explode ('-', $date);
        $alter_date = $year.'-'.$month.'-'.$day.' 00:00:00';
        $dql = "SELECT a.id, a.title, a.summary, a.date, a.language, ae.content,
                CASE WHEN (a.language = ".Article::SPANISH_LANGUAGE." OR a.language = ".Article::BOTH_LANGUAGE.") THEN 'es' ELSE 'en' as html_language
        FROM ECLBlogBundle:ArticleExtend ae
        JOIN ae.article a
        WHERE a.slug=:slug AND DATE_DIFF(a.date, :date) = 0 AND a.active = 1";
        
        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array ('slug' => $slug, 'date' => $alter_date))
            ->getSingleResult();
    }
    
    public function getTotalArticlesNum($language, $tag_slug = null)
    {
        $dql = 'SELECT a.id FROM ECLBlogBundle:Article a
        JOIN a.tags t
        WHERE a.active = 1 AND (a.language = :both_language OR a.language = :user_language)';
        if ($tag_slug !== null) {
            $dql .= ' AND t.slug=:slug';
        }
        $dql .= ' GROUP BY a.id';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('both_language', Article::BOTH_LANGUAGE);
        $query->setParameter('user_language', $this->getLanguageId($language));
        if ($tag_slug !== null) {
            $query->setParameter('slug', $tag_slug);
        }
        
        return count($query->getResult());
    }
    
    public function getLanguageId($language)
    {
        switch ($language) {
            case 'es':
                $language_id = Article::SPANISH_LANGUAGE;
                break;
            case 'en':
                $language_id = Article::ENGLISH_LANGUAGE;
                break;
        }
        
        return $language_id;
    }

}
