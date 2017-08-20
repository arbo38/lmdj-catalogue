<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function catalogueAction(Request $request)
    {
        $games = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->findAll();
        return $this->render('catalogue/index.html.twig', [
            'games' => $games
        ]);
    }

    /**
     * @Route("/game/{slug}", name="game_show")
     */
    public function showAction(Game $game)
    {

        return $this->render('catalogue/game_show.html.twig', [
            'game' => $game
        ]);
    }
}
