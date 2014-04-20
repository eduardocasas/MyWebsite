<?php
namespace ECL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ECL\BlogBundle\Entity\UserRepository")
 */
class User extends OAuthUser
{
    
    const NO_API       = 1;
    const GITHUB_API   = 2;
    const LINKEDIN_API = 3;
    const GOOGLE_API   = 4;
    const TWITTER_API  = 5;
    const FACEBOOK_API = 6;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="api", type="smallint")
     */
    private $api;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=400, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=600, nullable=true)
     */
    private $picture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
     /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;
    
    /**
     * @ORM\OneToOne(targetEntity="GithubUser", mappedBy="user")
     */
    private $github_user_api;
    
    /**
     * @ORM\OneToOne(targetEntity="LinkedinUser", mappedBy="user")
     */
    private $linkedin_user_api;
    
    /**
     * @ORM\OneToOne(targetEntity="FacebookUser", mappedBy="user")
     */
    private $facebook_user_api;

    /**
     * @ORM\OneToOne(targetEntity="TwitterUser", mappedBy="user")
     */
    private $twitter_user_api;
    
    /**
     * @ORM\OneToOne(targetEntity="GoogleUser", mappedBy="user")
     */
    private $google_user_api;
    
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
     * Set api
     *
     * @param integer $api
     * @return User
     */
    public function setApi($api)
    {
        $this->api = $api;
    
        return $this;
    }

    /**
     * Get api
     *
     * @return integer 
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return User
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return User
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
        
    public function getRoles()
    {
        return array();
    }
    
    public function __toString() {}
    
}
