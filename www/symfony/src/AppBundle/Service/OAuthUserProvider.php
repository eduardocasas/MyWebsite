<?php
namespace AppBundle\Service;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\User;
use AppBundle\Entity\GithubUser;
use AppBundle\Entity\LinkedinUser;
use AppBundle\Entity\GoogleUser;
use AppBundle\Entity\FacebookUser;
use AppBundle\Entity\TwitterUser;

class OAuthUserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{
    
    protected $session;
    protected $doctrine;
    protected $admins;
    private $user_api;
    private $request;
    
    public function __construct($session, $doctrine, $service_container, RequestStack $requestStack)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $service_container;
        $this->request = $requestStack->getCurrentRequest();
    }
    
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $this->setUserApi();
        $identifier = $response->getUsername();
        $ApiUser = $this->getApiUser($identifier);
        $em = $this->doctrine->getManager();
        $user_id = $this->getUserId($identifier);
        if (!$user_id) {
            $User = new User($identifier);
            $ApiUser->setUser($User);
            $User->setName($response->getRealName());
            $User->setUrl($ApiUser->getUrlByOAuthResponse($response));
            $User->setPicture($ApiUser->getPictureByOAuthResponse($response));
            $User->setDate(new \DateTime());
            $User->setApi($this->user_api);
            $em->persist($User);
            $em->persist($ApiUser);
            $em->flush();
        } else {
            $User = $em->getRepository('AppBundle:User')->find($user_id);
            $User->setName($response->getRealName());
            $User->setUrl($ApiUser->getUrlByOAuthResponse($response));
            $User->setPicture($ApiUser->getPictureByOAuthResponse($response));
            $em->persist($User);
            $em->flush();
        }
        $this->session->set('id', $User->getId());
        $this->session->set('url', $User->getUrl());
        $this->session->set('name', $User->getName());
        $this->session->set('picture', $User->getPicture());
        return $this->loadUserByUsername($identifier);
    }
    
    public function loadUserByUsername($identifier)
    {
        return new User($identifier);
    }
    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }
    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return null;
    }
    
    private function setUserApi()
    {
        $request = $this->request;
        $router = $this->container->get("router");
        $route = $router->match($request->getPathInfo());
        switch ($route['_route']) {
            case 'github_login_check':
                $user_api = User::GITHUB_API;
                break;
            case 'linkedin_login_check':
                $user_api = User::LINKEDIN_API;
                break;
            case 'google_login_check':
                $user_api = User::GOOGLE_API;
                break;
            case 'twitter_login_check':
                $user_api = User::TWITTER_API;
                break;
            case 'facebook_login_check':
                $user_api = User::FACEBOOK_API;
                break;
        }
        $this->user_api = $user_api;
    }
    
    private function getUserId($identifier)
    {
        switch ($this->user_api) {
            case User::GITHUB_API:
                $entity = 'AppBundle:GithubUser';
                break;
            case User::LINKEDIN_API:
                $entity = 'AppBundle:LinkedinUser';
                break;
            case User::GOOGLE_API:
                $entity = 'AppBundle:GoogleUser';
                break;
            case User::TWITTER_API:
                $entity = 'AppBundle:TwitterUser';
                break;
            case User::FACEBOOK_API:
                $entity = 'AppBundle:FacebookUser';
                break;
        }
        $dql = 'SELECT u.id FROM '.$entity.' ua JOIN ua.user u WHERE ua.identifier = :identifier';
        try {
            $result = $this->doctrine
            ->getManager()
            ->createQuery($dql)
            ->setParameters(['identifier' => $identifier])
            ->getSingleScalarResult();
        } catch (NoResultException $ex) {
            $result = false;
        }
        
        return $result;
    }
    
    private function getApiUser($identifier)
    {
        switch ($this->user_api) {
            case User::GITHUB_API:
                $ApiUser = (new GithubUser)->setidentifier($identifier);
                break;
            case User::LINKEDIN_API:
                $ApiUser = (new LinkedinUser)->setidentifier($identifier);
                break;
            case User::GOOGLE_API:
                $ApiUser = (new GoogleUser)->setidentifier($identifier);
                break;
            case User::TWITTER_API:
                $ApiUser = (new TwitterUser)->setidentifier($identifier);
                break;
            case User::FACEBOOK_API:
                $ApiUser = (new FacebookUser)->setidentifier($identifier);
                break;
        }
        return $ApiUser;
    }
    
}