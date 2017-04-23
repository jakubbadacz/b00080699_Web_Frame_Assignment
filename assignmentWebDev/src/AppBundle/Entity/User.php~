<?php
/**
 * Created by Jakub Badacz B00080699.
 * Date: 30/03/2017
 * Time: 18:24
 */

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *@ORM\Table(name="users")
 *@ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * @var \AppBundle\Entity\Tag
     * 
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="user")
     */
    private $tag;

    /**
     * @var \AppBundle\Entity\Nurl
     *
     * @ORM\OneToMany(targetEntity="Nurl", mappedBy="user")
     */
    private $nurl;

    /**
     * @var \AppBundle\Entity\Collection
     *
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="user")
     */
    private $collection;

    public function __construct()
    {
        $this->isActive = true;
    }

    public function getSalt()
    {
        return null;
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function getRoles()
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize()**/
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize()**/
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            )= unserialize($serialized);
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

//    public function __toString()
//    {
//        return $this -> getUsername();
//    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return User
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

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return User
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
     * Add collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return User
     */
    public function addCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collection[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\Collection $collection
     */
    public function removeCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collection->removeElement($collection);
    }

    /**
     * Get collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
