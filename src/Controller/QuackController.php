<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Duck;
use App\Entity\Quack;
use App\Entity\Tag;
use App\Form\CommentFormType;
use App\Form\QuackType;
use App\Repository\DuckRepository;
use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{
    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quack = new Quack($this->getUser());
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('profil', ['id'=>$this->getUser()->getId()]);
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET","POST"})
     */
    public function show(Quack $quack, Request $request): Response
    {
        $comment = new Comment();
        $comment->setQuack($quack);
        $comment->setDuck($this->getUser());
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('quack_show', ['id'=>$quack->getId()]);
        }

        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
            'commentsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack): Response
    {
        if ($quack->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="quack_delete", methods={"POST"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("comment/{id}/delete", name="comment_delete", methods={"POST"})
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {
        $previousQuack=$comment->getQuack()->getId();
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_show', ['id'=>$previousQuack]);
    }
}
