<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class AdminCategoryController extends Controller
{
    /**
     * @Route("/categories", name="admin_categories")
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();


        return $this->render('admin/category.html.twig', array('categories' => $categories));
    }

    /**
     * @Route("/category/{categoryId}/game/{gameId}", name="category_game_remove")
     * @Method("DELETE")
     */
    public function removeGameFromCategoryAction($categoryId, $gameId)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Category')->find($categoryId);
        $game = $em->getRepository('AppBundle:Game')->find($gameId);

        if(!$category || !$game){
            throw $this->createNotFoundException('Element not found in database');
        }

        $game->removeCategory($category);

        $em->flush();

        return new Response(null, 204);



    }
}
