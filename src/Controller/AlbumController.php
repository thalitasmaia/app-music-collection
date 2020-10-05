<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\HttpArtistService;

/**
 * @Route("/album")
 */
class AlbumController extends BaseController
{
    /**
     * @Route("/albums/{artistId}", name="album_index", methods={"GET"})
     */
    public function albumsList($artistId, AlbumRepository $albumRepository)
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artist = HttpArtistService::getOneArtist($artistId);

        $albums = $albumRepository->findBy(
            ['artistId' => $artist->id],
        );

        return $this->render('album/index.html.twig', [
            'albums' => $albums,
            'artist' => $artist,
            'isAdministrator' => $this->isAdministrator(),
        ]);
    }

    /**
     * @Route("/new/{artistId}", name="album_new", methods={"GET","POST"})
     */

    public function new($artistId, Request $request): Response
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artist = HttpArtistService::getOneArtist($artistId);

        $album = new Album();
        $album->setArtistId($artist->id);

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('success', 'Your register was successfully created!');

            return $this->redirectToRoute('album_index', ['artistId' => $artist->id]);
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
            'artist' => $artist
        ]);
    }

    /**
     * @Route("/{id}", name="album_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artist = HttpArtistService::getOneArtist($album->getArtistId());

        return $this->render('album/show.html.twig', [
            'album' => $album,
            'artist' => $artist
        ]);
    }

    /**
     * @Route("/edit/{id}", name="album_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Album $album): Response
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artist = HttpArtistService::getOneArtist($album->getArtistId());

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Your register was successfully edited!');

            return $this->redirectToRoute('album_index', ['artistId' => $artist->id]);
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
            'artist' => $artist
        ]);
    }

    /**
     * @Route("/{id}", name="album_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Album $album): Response
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artist = HttpArtistService::getOneArtist($album->getArtistId());

        if ($this->isCsrfTokenValid('delete' . $album->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($album);
            $entityManager->flush();

            $this->addFlash('success', 'Your register was successfully deleted!');
        }

        return $this->redirectToRoute('album_index', ['artistId' => $artist->id]);
    }
}
