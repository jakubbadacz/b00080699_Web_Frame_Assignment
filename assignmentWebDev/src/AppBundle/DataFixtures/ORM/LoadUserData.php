<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        //create user
        $userModerator = $this->createActiveUser('super', 'super@admin', 'super', ['ROLE_MODERATOR']);
        $userAdmin = $this->createActiveUser('admin', 'admin@admin.com', 'admin', ['ROLE_ADMIN']);
        $userJakub = $this->createActiveUser('jakub', 'jakub@jakub.com', 'jakub', ['ROLE_USER']);

        //store to DB
        $manager->persist($userModerator);
        $manager->persist($userAdmin);
        $manager->persist($userJakub);
        $manager->flush();
    }

    private function createActiveUser($username, $email, $plainPassword, $roles = ['ROLE_USER']):User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setIsActive(true);


        $encodedPassword = $this->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        return $user;
    }

    private function encodePassword($user, $plainPassword):string
    {
        $encoder = $this->container->get('security.password_encoder');
        $encodedPassword= $encoder->encodePassword($user, $plainPassword);
        return $encodedPassword;
    }

}