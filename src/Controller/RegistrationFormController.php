<?php


namespace App\Controller;


use App\Entity\UserFormEntity;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RegistrationFormController extends AbstractController
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * RegistrationFormController constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(
        HttpClientInterface $client
    ) {
        $this->client = $client;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function new(Request $request): Response
    {
        $userFormEntity = new UserFormEntity();

        $form = $this->createForm(RegistrationType::class, $userFormEntity);
        $form->handleRequest($request);


        if ($form->isSubmitted())
        {
            return $this->sendRequestAndRedirect($form);
        }

        return $this->render('RegistrationForm/registrationForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param FormInterface $form
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function sendRequestAndRedirect(FormInterface $form): Response
    {
        /** @var UserFormEntity $userFormEntity */
        $userFormEntity = $form->getData();

        $response = $this->client->request(
            'POST',
            $this->generateUrl('api_add_user', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ['body' => json_encode($userFormEntity)]
        );


        if($response->getStatusCode() === 200)
        {
            return $this->redirectToRoute('form_add_user_succeeded');
        }

        return $this->redirectToRoute('form_add_user');
    }

    /**
     * @return Response
     */
    public function newUserSuccess(): Response
    {
        return $this->render('RegistrationForm/registrationFormSuccess.html.twig');
    }
}