<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\DanceEvent;
use model\DanceArtist;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/danceEvent.php';
require_once __DIR__ . '/../model/danceArtist.php';


class Dancerepository extends dbconfig {
    /**
     * Tables:
     * dance_artists: artistId, name, image
     * dance_events: danceEventId, venue, address, dateTime, price, image
     * dance_participating_artists: id, danceEventId, danceArtistId
     */

    public function getDanceEvents() {
        $sql = 'SELECT * FROM dance_events';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $eventsData = $stmt->fetchAll();
            $events = [];
            foreach ($eventsData as $event) {
                $artists = $this->getArtistsByEventId($event['danceEventId']);
                $artists = array_map(function($artist) {
                    return new DanceArtist($artist['artistId'], $artist['name'], $artist['image']);
                }, $artists);
                $danceEvent = new DanceEvent($event['danceEventId'], $event['venue'], $event['address'], $event['dateTime'], $event['price'], $event['image'], $artists);
                array_push($events, $danceEvent);
            }

            return $events;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    private function getArtistsByEventId($eventId) {
        $sql = 'SELECT * FROM dance_artists JOIN dance_participating_artists ON dance_artists.artistId = dance_participating_artists.danceArtistId WHERE dance_participating_artists.danceEventId = :eventId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getArtists() {
        $sql = 'SELECT * FROM dance_artists';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function addArtist($name, $image) {
        $sql = 'INSERT INTO dance_artists (name, image) VALUES (:name, :image)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateArtist($artistId, $name, $image) {
        $sql = 'UPDATE dance_artists SET name = :name, image = :image WHERE artistId = :artistId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteArtist($artistId) {
        $sql = 'DELETE FROM dance_artists WHERE artistId = :artistId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addDanceEvent($venue, $address, $dateTime, $price, $image) {
        $sql = 'INSERT INTO dance_events (venue, address, dateTime, price, image) VALUES (:venue, :address, :dateTime, :price, :image)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
            //$danceEventId = $this->getConnection()->lastInsertId();
            //$this->addArtistsToEvent($danceEventId, $artists);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateDanceEvent($danceEventId, $venue, $address, $dateTime, $price, $image) {
        $sql = 'UPDATE dance_events SET venue = :venue, address = :address, dateTime = :dateTime, price = :price, image = :image WHERE danceEventId = :danceEventId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDanceEvent($danceEventId) {
        $sql = 'DELETE FROM dance_events WHERE danceEventId = :danceEventId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addArtistToEvent($danceEventId, $artistId) {
        $sql = 'INSERT INTO dance_participating_artists (danceEventId, danceArtistId) VALUES (:danceEventId, :danceArtistId)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->bindParam(':danceArtistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removeArtistFromEvent($danceEventId, $artistId) {
        $sql = 'DELETE FROM dance_participating_artists WHERE danceEventId = :danceEventId AND danceArtistId = :danceArtistId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->bindParam(':danceArtistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}