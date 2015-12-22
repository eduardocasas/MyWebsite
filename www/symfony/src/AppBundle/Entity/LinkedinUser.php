<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LinkedinUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class LinkedinUser
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="linkedin_user_api")
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
     * @return LinkedinUser
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
     * @return LinkedinUser
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
        return 'http://www.linkedin.com/profile/view?id='.$response->getUsername();
    }
    
    public function getPictureByOAuthResponse($response)
    {
        return $response->getProfilePicture();
    }
    
}
