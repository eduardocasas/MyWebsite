<?php
namespace ECL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\NoResultException;
use ECL\BlogBundle\Entity\Article;
use ECL\BlogBundle\Entity\Comment;
use ECL\BlogBundle\Form\Type\CommentType;


class DefaultController extends Controller
{
    
    const ITEMS_PER_PAGE = 8;

    public function commentCreateAction($date, $slug, $article_id)
    {
        if ($this->get('session')->get('name')) {
            $Comment = new Comment;
            $form = $this->createForm(new CommentType, $Comment);
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $Comment->setCreationDate(new \DateTime());
                $Comment->setActive(true);
                $Comment->setUser($this->getDoctrine()->getRepository('ECLBlogBundle:User')->find($this->get('session')->get('id')));
                $Comment->setArticle($this->getDoctrine()->getRepository('ECLBlogBundle:Article')->find($article_id));
                $em->persist($Comment);
                $em->flush();
            }
            $url = $this->generateURL('ecl_blog_article', array('date' => $date,'slug' => $slug));

            return $this->redirect($url.'#comments');
        }
    }

    public function showAction($date, $slug)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        try {
            $article = $em->getRepository('ECLBlogBundle:Article')->getArticleByDateAndSlug($date,$slug);
            if (!$this->articleLanguageIsAvailable($article['language'])) {
                return $this->redirect($this->generateURL('ecl_blog_homepage'), 301);
            }
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }
        $entity = new Comment;
        $form = $this->createForm(new CommentType, $entity);

        return $this->render(
            'ECLBlogBundle:'.$this->get('my.browser')->getFolder().'/Default:show.html.twig',
            array(
                'user_logged'  => $session->get('user_is_logged'),
                'user_id'      => $session->get('id'),
                'user_name'    => $session->get('nick'),
                'user_email'   => $session->get('email'),
                'logged_api'   => $session->get('api'),
                'tags'         => $em->getRepository('ECLBlogBundle:Tag')->getByArticle($article['id']),
                'article'      => $article,
                'article_date' => $date,
                'article_slug' => $slug,
                'comments'     => $em->getRepository('ECLBlogBundle:Comment')->getByArticle($article['id']),
                'form'         => $form->createView()
            )
        );
    }

    public function navAction($page = null, $tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $total_num_items = $em->getRepository('ECLBlogBundle:Article')->getTotalArticlesNum($tag_slug, $this->getLocale());
        $total_num_pages = ceil($total_num_items/self::ITEMS_PER_PAGE);
        if ($total_num_pages > 1) {
            $nav_array = array(
                'first'     => null,
                'last'      => null,
                'previous'  => null,
                'next'      => null,
                'last_page' => $total_num_pages
            );
            if ($page != null) {
                $nav_array['first'] = true;
                if ($page > 2) {
                    $nav_array['previous'] = $page-1;
                }            
            } else {
                $page = 1;
            }
            $nav_array['current_page'] = $page;
            if ($page != $total_num_pages) {
                $nav_array['last'] = $total_num_pages;
                if (($total_num_pages-$page) > 1) {
                   $nav_array['next'] = $page+1;
                }
            }

            return $this->render(
                'ECLBlogBundle:'.$this->get('my.browser')->getFolder().'/Default:nav.html.twig',
                array('nav_array' => $nav_array, 'tag_slug' => $tag_slug)
            );            
        } else {

            return new Response();
        }
    }
    
    public function indexAction($tag_slug = null, $page = null)
    {
        if (is_numeric($tag_slug)) {
            $page = $tag_slug;
            $tag_slug = null;
        }
        if ($page == 1) {
            
            return $this->redirect($this->generateURL('ecl_blog_homepage'), 301);
        }
        $em = $this->getDoctrine()->getManager();

        return $this->render(
            'ECLBlogBundle:'.$this->get('my.browser')->getFolder().'/Default:index.html.twig',
            array(
                'page'                   => $page,
                'tag_slug'               => $tag_slug,
                'blog_tag_selected_name' => ($tag_slug == null) ? null : $em->getRepository('ECLBlogBundle:Tag')->getNameBySlug($tag_slug),
                'blog_tag_selected'      => $tag_slug,
                'articles'               => $em->getRepository('ECLBlogBundle:Article')->getCollectionByPageTagLanguage($tag_slug, self::ITEMS_PER_PAGE, $page, $this->getLocale())
            )
        );
    }
    
    private function articleLanguageIsAvailable($language)
    {
        return $language == Article::BOTH_LANGUAGE ||
               $language == $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Article')->getLanguageId($this->getLocale());
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
