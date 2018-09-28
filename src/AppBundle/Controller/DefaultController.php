<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Tapa;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Repository\TapaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page"="\d+"})
     */
    public function indexAction($page = 1)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Tapa::class);

        $tapas = $repository->findTapasInPage($page);
        $totalPages = $repository->findTotalNumberOfPages();

        return $this->render('default/index.html.twig', [
            'tapas'      => $tapas,
            'page'       => $page,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * @Route("/about", name="about_us")
     */
    public function aboutUsAction()
    {
        return $this->render('default/about_us.html.twig');
    }

    /**
     * @Route("/contact/{location}", name="contact")
     */
    public function contactAction($location = 'Murcia Valencia Madrid')
    {
        return $this->render('default/contact.html.twig', [
            'location' => explode(' ', $location),
        ]);
    }

    /**
     * @Route("/tapa/{id}", name="detail_tapa")
     */
    public function tapaDetailAction($id = null)
    {
        $repository = $this->getDoctrine()->getRepository(Tapa::class);
        $tapa = $repository->find($id);

        if (!isset($tapa)) {
            throw $this->createNotFoundException('Tapa not found');
        }

        return $this->render('default/detail_tapa.html.twig', [
            'tapa' => $tapa,
        ]);
    }

    /**
     * @Route("/category/{id}", name="detail_category")
     */
    public function categoryDetailAction($id = null)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($id);

        if (!isset($category)) {
            throw $this->createNotFoundException('Category not found');
        }

        return $this->render('default/detail_category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/ingredient/{id}", name="detail_ingredient")
     */
    public function ingredientDetailAction($id = null)
    {
        $repository = $this->getDoctrine()->getRepository(Ingredient::class);
        $ingredient = $repository->find($id);

        if (!isset($ingredient)) {
            throw $this->createNotFoundException('Ingredient not found');
        }

        return $this->render('default/detail_ingredient.html.twig', [
            'ingredient' => $ingredient,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('default/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/tapas", name="tapas")
     */
    public function listTapasAction()
    {
        $repository = $this->getDoctrine()->getRepository(Tapa::class);
        $tapas = $repository->findAll();

        return $this->render('default/list_tapas.html.twig', [
            'tapas' => $tapas,
        ]);
    }

}
