<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Tapa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page"="\d+"})
     */
    public function indexAction(Request $request, $page = 1)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Tapa::class);

        $tapas = $repository->tapasPage($page);
        $totalPages = $repository->getNumberOfPages();

        return $this->render('default/index.html.twig', [
            'tapas'      => $tapas,
            'page'       => $page,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * @Route("/about", name="about_us")
     */
    public function aboutUsAction(Request $request)
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

}
