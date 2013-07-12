<?php

namespace User\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* BlogPost
 *
 * @ORM\Table(name="blog_post")
 * @ORM\Entity
 */
class BlogPost
{
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @var string
     */
    private $title;

    /**
     * 
     * @var string
     *  @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *  @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

     /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

    /**
     * @var \User\RegistrationBundle\Entity\UserRegistration
     *
     * @ORM\ManyToOne(targetEntity="\User\RegistrationBundle\Entity\UserRegistration", inversedBy="post" , cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
     
    private $user;

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
     * @param \User\RegistrationBundle\Entity\UserRegistration $user
     * @return BlogPost
     */
    public function setUser(\User\RegistrationBundle\Entity\UserRegistration $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \User\RegistrationBundle\Entity\UserRegistration 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogPost
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlogPost
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return BlogPost
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function __toString() {
        return $this->title;
    }
}