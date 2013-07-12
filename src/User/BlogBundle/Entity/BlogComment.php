<?php

namespace User\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use User\BlogBundle\Entity\BlogPost;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_comment")
 */
class BlogComment
{
    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
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
     * @var \User\BlogBundle\Entity\BlogPost
     * 
     * @ORM\ManyToOne(targetEntity="\User\BlogBundle\Entity\BlogPost")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

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
     * Set post
     *
     * @param \User\BlogBundle\Entity\BlogPost $post
     * @return BlogComment
     */
    public function setPost(\User\BlogBundle\Entity\BlogPost $post = null)
    {
        $this->post = $post;
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \User\BlogBundle\Entity\BlogPost 
     */
    public function getPost()
    {
        return $this->post;
    }
}