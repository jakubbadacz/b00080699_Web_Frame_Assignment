<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
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
     * @var string
     *
     * @ORM\Column(name="tagName", type="string", length=255)
     */
    private $tagName;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tag")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pending", type="boolean")
     */
    private $pending;



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
     * Set tagName
     *
     * @param string $tagName
     *
     * @return Tag
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * Get tagName
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Tag
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getTagName();
    }

    /**
     * Set pending
     *
     * @param boolean $pending
     *
     * @return Tag
     */
    public function setPending($pending)
    {
        $this->pending = $pending;

        return $this;
    }

    /**
     * Get pending
     *
     * @return boolean
     */
    public function getPending()
    {
        return $this->pending;
    }
}
