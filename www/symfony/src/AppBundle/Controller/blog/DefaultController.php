<?php

namespace AppBundle\Controller\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\Type\blog\CommentType;

class DefaultController extends Controller
{
    
    const ITEMS_PER_PAGE = 8;

    public function commentCreateAction($date, $slug, $article_id)
    {
        if ($this->get('session')->get('name')) {
            $url = $this->generateURL('blog_article', ['date' => $date,'slug' => $slug]).'#comments';
            $Comment = new Comment;
            $form = $this->createForm(new CommentType, $Comment);
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $Comment->setCreationDate(new \DateTime());
                $Comment->setActive(true);
                $Comment->setUser($this->getDoctrine()->getRepository('AppBundle:User')->find($this->get('session')->get('id')));
                $Article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($article_id);
                $Comment->setArticle($Article);
                $em->persist($Comment);
                $em->flush();
                $this->sendEmailToAdmin(
                    $this->get('session')->get('name'),
                    $Article->getTitle(),
                    $url,
                    $Comment->getText()
                );
            }

            return $this->redirect($url);
        }
    }

    public function showAction($date, $slug)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        try {
            $article = $em->getRepository('AppBundle:Article')->getArticleByDateAndSlug($date,$slug);
            if (!$this->articleLanguageIsAvailable($article['language'])) {
                return $this->redirect($this->generateURL('blog'), 301);
            }
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }
        $entity = new Comment;
        $form = $this->createForm(new CommentType, $entity);

        return $this->render( 'blog/show.html.twig', [
            'user_logged' => $session->get('user_is_logged'),
            'user_id' => $session->get('id'),
            'user_name' => $session->get('nick'),
            'user_email' => $session->get('email'),
            'logged_api' => $session->get('api'),
            'tags' => $em->getRepository('AppBundle:Tag')->getByArticle($article['id']),
            'article' => $article,
            'article_date' => $date,
            'article_slug' => $slug,
            'comments' => $em->getRepository('AppBundle:Comment')->getByArticle($article['id']),
            'form' => $form->createView(),
            'both_language_support' => Article::BOTH_LANGUAGE
        ]);
    }

    public function navAction($page = null, $tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $total_num_items = $em->getRepository('AppBundle:Article')->getTotalArticlesNum($this->getLocale(), $tag_slug);
        $total_num_pages = ceil($total_num_items/self::ITEMS_PER_PAGE);
        if ($total_num_pages > 1) {
            $nav_array = [
                'first' => null,
                'last' => null,
                'previous' => null,
                'next' => null,
                'last_page' => $total_num_pages
            ];
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

            return $this->render('blog/nav.html.twig', [
                'nav_array' => $nav_array, 'tag_slug' => $tag_slug
            ]);
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
            
            return $this->redirect($this->generateURL('blog'), 301);
        }
        $em = $this->getDoctrine()->getManager();
        try {
            $tag_name = ($tag_slug == null) ? null : $em->getRepository('AppBundle:Tag')->getNameBySlug($tag_slug);
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('blog/index.html.twig', [
            'page' => $page,
            'tag_slug' => $tag_slug,
            'blog_tag_selected_name' => $tag_name,
            'blog_tag_selected' => $tag_slug,
            'articles' => $em->getRepository('AppBundle:Article')->getCollectionByPageTagLanguage($this->getLocale(), $tag_slug, self::ITEMS_PER_PAGE, $page)
        ]);
    }
    
    private function articleLanguageIsAvailable($language)
    {
        return $language == Article::BOTH_LANGUAGE ||
               $language == $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->getLanguageId($this->getLocale());
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }
    
    private function sendEmailToAdmin($user_name, $article_title, $article_url, $comment)
    {
        $domain_url = $this->getRequest()->getScheme().'://'.$this->getRequest()->getHost();
        $message = \Swift_Message::newInstance()
            ->setSubject($user_name.' ha publicado un comentario en el blog')
            ->setFrom($this->container->getParameter('my_email_1'))
            ->setTo($this->container->getParameter('my_email'))
            ->setBody(
                '<strong>Usuario:</strong> '.$user_name.
                    '<br><br><strong>Artículo:</strong> '.$article_title.
                     '<br><br><strong>url:</strong> '.$domain_url.$article_url.
                     '<br><br><strong>Comentario:</strong><br><br>'.$comment,
                'text/html'
            );
        $this->get('mailer')->send($message);
    }

}
