<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *      path="/api/users",
     *      name="users_list"
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

    /**
     * @Rest\Get(
     *      path="/api/users/{id}",
     *      name="users_detail",
     *      requirements = {"id"="\d+"}
     * )
     * @Entity("user", expr="repository.findOneWhithAllEntities(id)")
     *
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function detail(User $user)
    {
        return $user;
    }
}
