<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Collection
 *
 * @ORM\Table(name="collection")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollectionRepository")
 */
class Collection
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \AppBundle\Entity\Nurl
     *
     * @ORM\OneToMany(targetEntity="Nurl", mappedBy="collection")
     */
    private $nurl;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="collection")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Collection
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
     * Constructor
     */
    public function __construct()
    {
        $this->nurl = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return Collection
     */
    public function addNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurl[] = $nurl;

        return $this;
    }

    /**
     * Remove nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     */
    public function removeNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurl->removeElement($nurl);
    }

    /**
     * Get nurl
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNurl()
    {
        return $this->nurl;
    }


    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Collection
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
}
