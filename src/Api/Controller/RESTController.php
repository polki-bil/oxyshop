<?php

namespace App\Controller;

use App\CoreDomain\UserFactory;
use App\CoreDomain\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RESTController extends AbstractController
{
    /**
     * @var RequestValidator
     */
    private $validator;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * RESTController constructor.
     * @param RequestValidator $validator
     * @param UserService $userService
     * @param UserFactory $userFactory
     */
    public function __construct(
        RequestValidator $validator,
        UserService $userService,
        UserFactory $userFactory
    ) {
        $this->validator = $validator;
        $this->userService = $userService;
        $this->userFactory = $userFactory;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addUser(Request $request): Response
    {
        if (!$this->validator->validateJSONData($request->getContent()))
        {
            return new Response('Bad Bad request', Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userFactory->createFromJson($request->getContent());

        if ($this->userService->AddUser($user))
        {
            return new Response('OK', Response::HTTP_OK);
        }

        return new Response('Bad Bad request', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return Response
     */
    public function listUsers(): Response
    {
        $users = $this->userService->findAllUsers();

        return new Response(json_encode($users), Response::HTTP_OK);
    }
}
