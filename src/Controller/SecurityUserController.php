<?php

namespace App\Controller;

use App\Entity\User;

use Swift_Mailer;
use Swift_Message;
use App\Repository\UserRepository;
use App\Form\FogotPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class SecurityUserController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $repo): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('affiche');

        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['form' => $lastUsername, 'error' => $error]);
    }





    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


     #[Route(path: '/forgot', name: 'forgot')]

    public function forgotPassword(Request $request, UserRepository $userRepository,Swift_Mailer $mailer, TokenGeneratorInterface  $tokenGenerator)
    {


        $form = $this->createForm(FogotPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();//


            $user = $userRepository->findOneBy(['Adresse'=>$donnees]);
            if(!$user) {
                $this->addFlash('danger','cette adresse n\'existe pas');
                return $this->redirectToRoute("forgot");

            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManger = $this->getDoctrine()->getManager();
                $entityManger->persist($user);
                $entityManger->flush();




            }catch(\Exception $exception) {
                $this->addFlash('warning','une erreur est survenue :'.$exception->getMessage());
                return $this->redirectToRoute("app_login");


            }

            $url = $this->generateUrl('app_reset_password',array('token'=>$token),UrlGeneratorInterface::ABSOLUTE_URL);

            //BUNDLE MAILER
            $message = (new Swift_Message('Mot de password oublié'))
                ->setFrom('bacem.mallek999@gmail.com')
                ->setTo($user->getAdresse())
                ->setBody("<p> Bonjour</p> unde demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :".$url,
                    "text/html");

            //send mail
            $mailer->send($message);
            $this->addFlash('message','E-mail  de réinitialisation du mp envoyé :');
            //    return $this->redirectToRoute("app_login");


        }

        return $this->render("security/forgotPassword.html.twig",['form'=>$form->createView()]);
    }


    #[Route(path: '/resetpassword/{token}', name: 'app_reset_password')]

    public function resetpassword(Request $request,String $token,UserPasswordHasherInterface $userPasswordHasher)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$token]);

       // dd($request->request->get('password'));

        if($user == null ) {
            $this->addFlash('danger','TOKEN INCONNU');
            return $this->redirectToRoute("app_login");

        }

        if($request->isMethod('POST')) {

            $user->setResetToken("");
           // dd($request->request->get('password'));
            $user->setMotPasse($userPasswordHasher->hashPassword($user,$request->request->get('MotPasse')));

            //$user->setMotPasse($passwordEncoder->encodePassword($user,'test123'));
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($user);
            $entityManger->flush();

            $this->addFlash('message','Mot de passe mis à jour :');
            return $this->redirectToRoute("app_login");

        }
        else {
            return $this->render("security/resetPassword.html.twig",['token'=>$token]);

        }
    }


}
