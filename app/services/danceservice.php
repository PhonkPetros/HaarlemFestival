<?php

namespace services;

use repositories\Dancerepository;

require_once __DIR__ . '/../repositories/dancerepository.php';

class DanceService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new Dancerepository();
    }

    public function getDanceEvents()
    {
        return $this->repository->getDanceEvents();
    }

    public function getArtists()
    {
        return $this->repository->getArtists();
    }

    public function addArtist($name, $image)
    {
        $this->repository->addArtist($name, $image);
    }

    public function updateArtist($artistId, $name, $image)
    {
        $this->repository->updateArtist($artistId, $name, $image);
    }

    public function deleteArtist($artistId)
    {
        $this->repository->deleteArtist($artistId);
    }

    public function addDanceEvent($venue, $address, $dateTime, $price, $image)
    {
        $this->repository->addDanceEvent($venue, $address, $dateTime, $price, $image);
    }

    public function updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $image)
    {
        $this->repository->updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $image);
    }

    public function deleteDanceEvent($danceEventId)
    {
        $this->repository->deleteDanceEvent($danceEventId);
    }

    public function addArtistToEvent($danceEventId, $artistId)
    {
        $this->repository->addArtistToEvent($danceEventId, $artistId);
    }

    public function removeArtistFromEvent($danceEventId, $artistId)
    {
        $this->repository->removeArtistFromEvent($danceEventId, $artistId);
    }

}


