<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractFOSRestController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * RegistrationController constructor.
     * @param UserRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserRepository $repository, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /**
     * @Rest\Post("/api/sign_up")
     * @param Request $request
     * @return View
     */
    public function register(Request $request) {
        $email = $request->get('email');
        $password = $request->get('password');
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');

        $alreadyRegistred = $this->repository->findOneBy(['email' => $email]);
        if(isset($alreadyRegistred) && !empty($alreadyRegistred)) {
            return $this->view(['message' => 'Email already registred'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setLatitude($latitude);
        $user->setLongitude($longitude);
        $user->setPassword(
            $this->encoder->encodePassword($user, $password)
        );

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            return $this->view(['message' => 'An error occurred'], Response::HTTP_BAD_REQUEST);
        }
        return $this->view($user, Response::HTTP_CREATED)->setContext((new Context())->setGroups(['public']));
    }
}