<?php
namespace ECL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    
    public function logoutAction($date, $slug)
    {
        $Session = new Session;
        $Session->remove('id');
        $Session->remove('url');
        $Session->remove('name');
        $Session->remove('picture');

        return $this->redirect($this->generateURL('ecl_blog_article', ['date' => $date,'slug' => $slug]).'#comments');
    }
    
    public function loginGithubAction($date, $slug)
    {
        return $this->login('github_login_connect', $date, $slug);
        
    }
    
    public function loginLinkedinAction($date, $slug)
    {
        return $this->login('linkedin_login_connect', $date, $slug);
    }
    
    public function loginGoogleAction($date, $slug)
    {
        return $this->login('google_login_connect', $date, $slug);
    }
    
    public function loginFacebookAction($date, $slug)
    {
        return $this->login('facebook_login_connect', $date, $slug);
    }
    
    public function loginTwitterAction($date, $slug)
    {
        return $this->login('twitter_login_connect', $date, $slug);
    }
    
    public function redirectToArticleAction()
    {
        $Session = new Session;
        $url_redirect = $Session->get('url_redirect');
        $Session->remove('url_redirect');
        return $this->redirect($url_redirect);
    }
    
    private function login($url_login, $date, $slug)
    {
        (new Session)->set('url_redirect', $this->generateURL('ecl_blog_article', ['date' => $date,'slug' => $slug]).'#comments');
        return $this->redirect($this->generateURL($url_login));
    }

}
