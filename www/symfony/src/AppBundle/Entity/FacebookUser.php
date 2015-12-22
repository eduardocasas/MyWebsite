<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FacebookUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FacebookUser
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
     * @var integer
     * 
     * @ORM\OneToOne(targetEntity="User", inversedBy="facebook_user_api")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;


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
     * Set user
     *
     * @param integer $user
     * @return FacebookUser
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return FacebookUser
     */
    public function setidentifier($identifier)
    {
        $this->identifier = $identifier;
    
        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getidentifier()
    {
        return $this->identifier;
    }
    
    public function getUrlByOAuthResponse($response)
    {
        return 'https://www.facebook.com/'.$response->getUsername();
    }
    
    public function getPictureByOAuthResponse($response)
    {
        return 'http://graph.facebook.com/'.$response->getNickname().'/picture';
    }
    
}
