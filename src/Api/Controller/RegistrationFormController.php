<?php


namespace App\Controller;


use App\CoreDomain\UserFactory;
use App\CoreDomain\UserService;
use App\Entity\UserFormEntity;
use App\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationFormController extends AbstractController
{
    /**
     * @var RequestValidator
     */
    private RequestValidator $validator;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var UserFactory
     */
    private UserFactory $userFactory;

    /**
     * RegistrationFormController constructor.
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
    public function new(Request $request): Response
    {
        $userFormEntity = new UserFormEntity();

        $form = $this->createForm(RegistrationType::class, $userFormEntity);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            /** @var UserFormEntity $userFormEntity */
            $userFormEntity = $form->getData();

            $user = $this->userFactory->create(
                $userFormEntity->getName(),
                $userFormEntity->getPassword(),
                $userFormEntity->getEmail(),
                $userFormEntity->getRole(),
            );

            if ($this->userService->AddUser($user))
            {
                return $this->redirectToRoute('form_add_user_succeeded');
            }

            return $this->redirectToRoute('form_add_user');
        }

        return $this->render('RegistrationForm/registrationForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function newUserSuccess(): Response
    {
        return $this->render('RegistrationForm/registrationFormSuccess.html.twig');
    }
}