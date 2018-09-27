<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/categories", methods={"GET", "HEAD"})
     */
    public function listCategoriesAction(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        $json_categories = [];
        foreach ($categories as $category) {
            $json_categories[] = $this->serializeCategory($category);
        }

        return new JsonResponse($json_categories);
    }

    private function serializeCategory(Category $category)
    {
        return [
            'id'          => $category->getId(),
            'name'        => $category->getName(),
            'description' => $category->getDescription(),
            'picture'     => $category->getPicture(),

        ];
    }

    /**
     * @Route("/insertCategory", methods={"POST"})
     */
    public function insertCategoryAction(Request $request): Response
    {
        if ($this->isMissingParams($request)) {
            return new JsonResponse($this->badRequest(), 400);
        }

        $category = $this->creatingCategoryObj($request);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($category);
        $manager->flush();

        $data['category'] = $this->serializeCategory($category);

        return new JsonResponse($data, 200);
    }

    private function isMissingParams(Request $request)
    {
        return $request->get('name') == null ||
            $request->get('description') == null;
    }

    private function creatingCategoryObj(Request $request)
    {
        $category = new Category();
        $category->setName($request->get('name'));
        $category->setDescription($request->get('description'));
        $picture = ($request->get('picture') ? $request->get('picture') : 'nopic.jpg');
        $category->setPicture($picture);

        return $category;
    }

    private function badRequest()
    {
        return ['error' => 'missing elements'];
    }
}