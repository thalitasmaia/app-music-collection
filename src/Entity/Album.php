<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $artistId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $albumName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistId(): ?int
    {
        return $this->artistId;
    }

    public function setArtistId(int $artistId): self
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function getAlbumName(): ?string
    {
        return $this->albumName;
    }

    public function setAlbumName(string $albumName): self
    {
        $this->albumName = $albumName;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }
}
