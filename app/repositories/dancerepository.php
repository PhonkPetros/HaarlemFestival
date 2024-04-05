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
        $sql = 'SELECT * FROM dance_events
        JOIN venues ON dance_events.venue = venues.venueId
        JOIN [Event] ON dance_events.danceEventId = [Event].dance_event_id';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $eventsData = $stmt->fetchAll();
            $events = [];
            foreach ($eventsData as $event) {
                $artists = $this->getArtistsByEventId($event['danceEventId']);
                $artists = array_map(function($artist) {
                    return new DanceArtist($artist['artistId'], $artist['name'], $artist['profile']);
                }, $artists);
                $danceEvent = new DanceEvent($event['danceEventId'], $event["venueId"], $event['name'], $event['location'], $event['dateTime'], $event['price'], $event['oneDayPrice'], $event['allDaysPrice'], $event['image'], $artists);
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

    public function getArtistById($artistId) {
        $sql = "SELECT
        dance_artists.name as artistName, dance_artists.description, dance_artists.profile, 
        dance_artists.image1, dance_artists.image2, dance_artists.image3, dance_artists.video, dance_artists.album,
        dance_events.danceEventId, [Event].event_id, dance_events.dateTime, dance_events.endDateTime, dance_events.image, dance_events.price, venues.name as venueName, venues.location, venues.picture as venuePicture,
        dance_events.allDaysPrice, dance_events.oneDayPrice
        FROM dance_artists
        JOIN dance_participating_artists ON dance_artists.artistId = dance_participating_artists.danceArtistId
        JOIN dance_events ON dance_participating_artists.danceEventId = dance_events.danceEventId
        JOIN venues ON dance_events.venue = venues.venueId
        JOIN [Event] ON dance_events.danceEventId = [Event].dance_event_id
        WHERE dance_artists.artistId = :artistId";
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getVenues() {
        $sql = 'SELECT * FROM venues';
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

    public function addVenue($name, $location, $picture) {
        $sql = 'INSERT INTO venues (name, location, picture) VALUES (:name, :location, :picture)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateVenue($venueId, $name, $location, $picture) {
        $fieldsToUpdate = array(
            'name' => $name,
            'location' => $location,
            'picture' => $picture
        );
    
        $sql = 'UPDATE venues SET ';
        $setStatements = array();
    
        foreach ($fieldsToUpdate as $field => $value) {
            if ($value !== null) {
                $setStatements[] = "$field = :$field";
            }
        }
    
        $sql .= implode(', ', $setStatements) . ' WHERE venueId = :venueId';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
    
            foreach ($fieldsToUpdate as $field => $value) {
                if ($value !== null) {
                    $stmt->bindParam(":$field", $fieldsToUpdate[$field]);
                }
            }
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteVenue($venueId) {
        $sql = 'DELETE FROM venues WHERE venueId = :venueId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
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

    public function addArtist($name, $description, $profile, $image1, $image2, $image3, $video, $album) {
        $fieldsToInsert = array(
            'name' => $name,
            'description' => $description,
            'profile' => $profile,
            'image1' => $image1,
            'image2' => $image2,
            'image3' => $image3,
            'video' => $video,
            'album' => $album
        );
    
        $sql = 'INSERT INTO dance_artists (';
        $fields = array();
        $placeholders = array();
    
        foreach ($fieldsToInsert as $field => $value) {
            if ($value !== null) {
                $fields[] = $field;
                $placeholders[] = ":$field";
            }
        }
    
        $sql .= implode(', ', $fields) . ') VALUES (' . implode(', ', $placeholders) . ')';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
    
            foreach ($fieldsToInsert as $field => $value) {
                if ($value !== null) {
                    $stmt->bindParam(":$field", $fieldsToInsert[$field]);
                }
            }
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }    

    public function updateArtist($artistId, $name, $description, $profile, $image1, $image2, $image3, $video, $album) {
        $fieldsToUpdate = array(
            'name' => $name,
            'description' => $description,
            'profile' => $profile,
            'image1' => $image1,
            'image2' => $image2,
            'image3' => $image3,
            'video' => $video,
            'album' => $album
        );
    
        $sql = 'UPDATE dance_artists SET ';
        $setStatements = array();
    
        foreach ($fieldsToUpdate as $field => $value) {
            if ($value !== null) {
                $setStatements[] = "$field = :$field";
            }
        }
    
        $sql .= implode(', ', $setStatements) . ' WHERE artistId = :artistId';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
    
            foreach ($fieldsToUpdate as $field => $value) {
                if ($value !== null) {
                    $stmt->bindParam(":$field", $fieldsToUpdate[$field]);
                }
            }
    
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

    public function addDanceEvent($venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image) {
        $sql = 'INSERT INTO dance_events (venue, dateTime, price, oneDayPrice, allDaysPrice image) VALUES (:venue, :dateTime, :price, :oneDayPrice, :allDaysPrice :image)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':oneDayPrice', $oneDayPrice, PDO::PARAM_STR);
            $stmt->bindParam(':allDaysPrice', $allDaysPrice, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();

            $danceEventId = $this->getConnection()->lastInsertId();
            $this->addArtistsToEvent($danceEventId, $artists);
            $this->addEvent($danceEventId);

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function addEvent($danceEventId) {
        $sql = 'INSERT INTO [Event] (dance_event_id) VALUES (:dance_event_id)';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':dance_event_id', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function deleteEvent($danceEventId) {
        $sql = 'DELETE FROM [Event] WHERE dance_event_id = :dance_event_id';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':dance_event_id', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateDanceEventWithImage($danceEventId, $venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists, $image) {
        $sql = 'UPDATE dance_events SET venue = :venue, dateTime = :dateTime, price = :price, oneDayPrice = :oneDayPrice, allDaysPrice = :allDaysPrice, image = :image WHERE danceEventId = :danceEventId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':oneDayPrice', $oneDayPrice, PDO::PARAM_STR);
            $stmt->bindParam(':allDaysPrice', $allDaysPrice, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();

            $this->removeArtistsFromEvent($danceEventId);
            $this->addArtistsToEvent($danceEventId, $artists);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateDanceEvent($danceEventId, $venue, $dateTime, $price, $oneDayPrice, $allDaysPrice, $artists) {
        $sql = 'UPDATE dance_events SET venue = :venue, dateTime = :dateTime, price = :price, oneDayPrice = :oneDayPrice, allDaysPrice = :allDaysPrice WHERE danceEventId = :danceEventId';
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':dateTime', $dateTime, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':oneDayPrice', $oneDayPrice, PDO::PARAM_STR);
            $stmt->bindParam(':allDaysPrice', $allDaysPrice, PDO::PARAM_STR);
            $stmt->bindParam(':danceEventId', $danceEventId, PDO::PARAM_INT);
            $stmt->execute();

            $this->removeArtistsFromEvent($danceEventId);
            $this->addArtistsToEvent($danceEventId, $artists);
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

            $this->deleteEvent($danceEventId);
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

    public function addArtistsToEvent($danceEventId, $artists) {
        $artists = explode(',', $artists);
        foreach ($artists as $artist) {
            $this->addArtistToEvent($danceEventId, $artist);
        }
    }

    public function removeArtistsFromEvent($danceEventId) {
        $sql = 'DELETE FROM dance_participating_artists WHERE danceEventId = :danceEventId';
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
}