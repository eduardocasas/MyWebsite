<?php
namespace ECL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GithubUser
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GithubUser
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="github_user_api")
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
     * @return GithubUser
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
     * @return GithubUser
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
        return 'https://github.com/'.$response->getNickname();
    }
    
    public function getPictureByOAuthResponse($response)
    {
        return $response->getProfilePicture();
    }
    
}
