<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Nurl
 *
 * @ORM\Table(name="nurl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NurlRepository")
 */
class Nurl
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="nurl")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Collection
     *
     * @ORM\ManyToOne(targetEntity="Collection", inversedBy="nurl")
     * @ORM\JoinColumn(name="collection_id", referencedColumnName="id")
     */
    private $collection;

    /**
     * @var \AppBundle\Entity\Tag
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     *
     */
    private $tag;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pending", type="boolean")
     */
    private $pending;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Nurl
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
     * Set link
     *
     * @param string $link
     *
     * @return Nurl
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Nurl
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Nurl
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

    /**
     * Set collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return Nurl
     */
    public function setCollection(\AppBundle\Entity\Collection $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \AppBundle\Entity\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Nurl
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getTitle();
    }

    /**
     * Set pending
     *
     * @param boolean $pending
     *
     * @return Nurl
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
