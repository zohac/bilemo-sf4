<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Client;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *      path="/api/users",
     *      name="user_list"
     * )
     *
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function list(UserRepository $manager, UserInterface $user = null)
    {
        return $manager->findAllWhithAllEntities($user);
    }
}
