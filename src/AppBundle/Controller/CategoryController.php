<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {

        $em = $this->getDoctrine()->getManager();
        $games = $this->getDoctrine()->getRepository('AppBundle:Game')->findAll();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $gameKey = array_rand($games);
        $categoryKey = array_rand($categories);

        $game = $games[$gameKey];
        $category = $categories[$categoryKey];

        $game->addCategory($category);

        $em->persist($game);
        $em->flush();

        dump($game, $category);


        return $this->render('test.html.twig');
    }

    /**
     * @Route("category/{slug}", name="show_category")
     */
    public function showAction(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    public function menuAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('category/category_menu.html.twig', [
            'categories' => $categories
        ]);
    }
}
