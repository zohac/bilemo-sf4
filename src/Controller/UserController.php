<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @Rest\Post(
     *      path="/api/users",
     *      name="users_detail",
     * )
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @Rest\View(StatusCode = 201)
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function create(
        User $user,
        UserInterface $originator = null,
        UserPasswordEncoderInterface $encoder,
        ObjectManager $entityManager,
        ConstraintViolationList $violations
    ) {
        // Check the contraint in user entiy
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf('Field %s: %s ', $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        // Set the Customer
        $user->setCustomer($originator->getCustomer());
        // Encode the password
        $password = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        // Set Role
        $user->setRoles(['ROLE_USER']);

        // Save the new user
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
