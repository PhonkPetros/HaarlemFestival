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

    public function getArtistById($artistId)
    {
        return $this->repository->getArtistById($artistId);
    }

    public function getVenues()
    {
        return $this->repository->getVenues();
    }

    public function addVenue($name, $location, $picture) {
        $this->repository->addVenue($name, $location, $picture);
    }

    public function updateVenue($venueId, $name, $location, $picture) {
        $this->repository->updateVenue($venueId, $name, $location, $picture);
    }

    public function deleteVenue($venueId) {
        $this->repository->deleteVenue($venueId);
    }

    public function addArtist($name, $description, $profile, $image1, $image2, $image3, $video, $album)
    {
        $this->repository->addArtist($name, $description, $profile, $image1, $image2, $image3, $video, $album);
    }
    

    public function updateArtist($artistId, $name, $description, $profile, $image1, $image2, $image3, $video, $album)
    {
        $this->repository->updateArtist($artistId, $name, $description, $profile, $image1, $image2, $image3, $video, $album);
    }

    public function deleteArtist($artistId)
    {
        $this->repository->deleteArtist($artistId);
    }

    public function addDanceEvent($venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image)
    {
        $this->repository->addDanceEvent($venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image);
    }

    public function updateDanceEventWithImage($danceEventId, $venue, $address, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image)
    {
        $this->repository->updateDanceEventWithImage($danceEventId, $venue, $address, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image);
    }

    public function updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists)
    {
        $this->repository->updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists);
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


