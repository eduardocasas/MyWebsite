<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoogleUser.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GoogleUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * 
     * @ORM\OneToOne(targetEntity="User", inversedBy="google_user_api")
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user.
     *
     * @param int $user
     *
     * @return GoogleUser
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set identifier.
     *
     * @param string $identifier
     *
     * @return GoogleUser
     */
    public function setidentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier.
     *
     * @return string
     */
    public function getidentifier()
    {
        return $this->identifier;
    }

    public function getUrlByOAuthResponse($response)
    {
        return 'https://plus.google.com/'.$response->getUsername();
    }

    public function getPictureByOAuthResponse($response)
    {
        return $response->getProfilePicture();
    }
}
