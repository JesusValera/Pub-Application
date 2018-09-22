<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Tapa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{page}", name="homepage")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $tapas = $this->executeTapasQuery($page);

        return $this->render('default/index.html.twig', [
            'tapas' => $tapas,
            'page'  => $page,
        ]);
    }

    private function executeTapasQuery($page): array
    {
        $NUM_TAPAS = 3;
        $page = ($page <= 0) ? 1 : $page;

        $repository = $this->getDoctrine()->getRepository(Tapa::class);

        $query = $repository->createQueryBuilder('t')
            ->where('t.top = 1')
            ->setFirstResult($NUM_TAPAS * ($page - 1))
            ->setMaxResults($NUM_TAPAS)
            ->orderBy('t.id', 'ASC')
            ->getQuery();

        return $query->getResult();
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
