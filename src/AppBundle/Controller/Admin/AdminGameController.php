<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/admin")
 */
class AdminGameController extends Controller
{
    /**
     * @Route("/game", name="admin_game", methods={"GET"})
     */
    public function showAllAction()
    {
        $games = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->findAll();
        $session = new Session();
        $session->set('moi', $games);
        dump($session->get('moi'));
        return $this->render('admin/game.html.twig', compact('games'));
    }

    /**
     * @Route("/game/{id}", name="admin_game_edit", requirements={"id" = "\d+"})
     */
    public function editAction(Request $request, $id = 1)
    {
        $game = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->find($id);
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($game);
            $em->flush();

            $this->addFlash('success', 'Le jeu a bien ete edite');

            return $this->redirectToRoute('admin_game');
        }

        return $this->render('admin/game_edit.html.twig', [
            'game' => $game,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/game/add", name="admin_game_add")
     */
    public function addAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($game);
            $em->flush();

            $this->addFlash('success', 'Le jeu a bien ete ajoute');

            return $this->redirectToRoute('admin_game_edit', ['id' => $game->getId()]);
        }

        return $this->render('admin/game_edit.html.twig', [
            'game' => $game,
            'form' => $form->createView()
        ]);
    }
}
