<?php

namespace App\Controller;

use App\Service\HttpArtistService;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\BaseController;

class ArtistController extends BaseController
{
    /**
     * @Route("/", name="artists_index")
     */
    public function index()
    {
        if (!$this->hasPermission())
            return $this->redirectToRoute('app_login');

        $artists = HttpArtistService::getArtistList();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }
}
