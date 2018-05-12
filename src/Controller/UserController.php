<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\User\UserInterface;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *      path="/users",
     *      name="user_list"
     * )
     * 
     * @Rest\View()
     */
    public function list(UserRepository $manager, UserInterface $user)
    {
        return $manager->findAllWhithAllEntities($user);
    }
}
