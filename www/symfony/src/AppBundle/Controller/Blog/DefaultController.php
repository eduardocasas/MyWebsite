<?php

namespace AppBundle\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\Type\Blog\CommentType;

class DefaultController extends Controller
{
    const ITEMS_PER_PAGE = 8;

    public function commentCreateAction(Request $request, $date, $slug, $article_id)
    {
        if ($this->get('session')->get('name')) {
            $url = $this->generateURL('blog_article', ['date' => $date, 'slug' => $slug]).'#comments';
            $Comment = new Comment();
            $form = $this->createForm(CommentType::class, $Comment);
            $form->handleRequest($request);
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
                    $request,
                    $this->get('session')->get('name'),
                    $Article->getTitle(),
                    $url,
                    $Comment->getText()
                );
            }

            return $this->redirect($url);
        }
    }

    public function showAction(Request $request, $date, $slug)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        try {
            $article = $em->getRepository('AppBundle:Article')->getArticleByDateAndSlug($date, $slug);
            if (!$this->articleLanguageIsAvailable($request, $article['language'])) {
                return $this->redirect($this->generateURL('blog'), 301);
            }
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }
        $entity = new Comment();
        $form = $this->createForm(CommentType::class, $entity);

        return $this->render('blog/show.html.twig', [
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
            'both_language_support' => Article::BOTH_LANGUAGE,
        ]);
    }

    public function navAction(Request $request, $page = null, $tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $total_num_items = $em->getRepository('AppBundle:Article')->getTotalArticlesNum($request->getLocale(), $tag_slug);
        $total_num_pages = ceil($total_num_items / self::ITEMS_PER_PAGE);
        if ($total_num_pages > 1) {
            $nav_array = [
                'first' => null,
                'last' => null,
                'previous' => null,
                'next' => null,
                'last_page' => $total_num_pages,
            ];
            if ($page != null) {
                $nav_array['first'] = true;
                if ($page > 2) {
                    $nav_array['previous'] = $page - 1;
                }
            } else {
                $page = 1;
            }
            $nav_array['current_page'] = $page;
            if ($page != $total_num_pages) {
                $nav_array['last'] = $total_num_pages;
                if (($total_num_pages - $page) > 1) {
                    $nav_array['next'] = $page + 1;
                }
            }

            return $this->render('blog/nav.html.twig', [
                'nav_array' => $nav_array, 'tag_slug' => $tag_slug,
            ]);
        } else {
            return new Response();
        }
    }

    public function indexAction(Request $request, $tag_slug = null, $page = null)
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
            'articles' => $em->getRepository('AppBundle:Article')->getCollectionByPageTagLanguage($request->getLocale(), $tag_slug, self::ITEMS_PER_PAGE, $page),
        ]);
    }

    private function articleLanguageIsAvailable($request, $language)
    {
        return $language == Article::BOTH_LANGUAGE ||
               $language == $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->getLanguageId($request->getLocale());
    }

    private function sendEmailToAdmin($request, $user_name, $article_title, $article_url, $comment)
    {
        $domain_url = $request->getScheme().'://'.$request->getHost();
        $message = \Swift_Message::newInstance()
            ->setSubject($this->container->getParameter('mailer_prefix_site').$user_name.' ha comentado un artículo')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($this->container->getParameter('mailer_user'))
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
