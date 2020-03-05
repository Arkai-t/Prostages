<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    
    public function logout()
    {
    }

    public function inscription(Request $requetteHttp, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $formulaireUser = $this -> createForm(UserType::class, $user);

        $formulaireUser->handleRequest($requetteHttp);

        if($formulaireUser->isSubmitted() && $formulaireUser->isValid())
        {
            //Ajouter roles à l'utilisateur
            $user->setRoles(['ROLE_USER']);

            //Encoder mot de passe
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encodagePassword);

            //Enregistrer en BD
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/inscription.html.twig', ['vueformulaireUser' => $formulaireUser->createView()]);
    }
}
