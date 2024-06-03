<?php
declare(strict_types=1);
namespace Controllers;

use Models\Hikes;

class HikesController
{
//    public  static function test(){
//        echo 'tags controller test';
//
//    }

    public static function getHikeNames(int $page = 1): array
    {
        $hikesModel = new Hikes();
        return $hikesModel->getAllNames($page);
    }
    public static function getHikesByTag(string $tag, int $page = 1, int $itemsPerPage = 6): array
    {
        return Hikes::getHikesByTag($tag, $page, $itemsPerPage);
    }

    public static function getHikesByUser(int $userId): array
    {
        $hikesModel = new Hikes();
        return $hikesModel->getHikesByUser($userId);
    }

    public static function getHikeUsers(int $userId, int $page = 1): array
    {
        $hikesModel = new Hikes();
        return $hikesModel->getHikesByUser($userId, $page);
    }

    public static function deleteHike(int $hikeId): void
    {
        $hikesModel = new Hikes();
        $hikesModel->deleteHikeById($hikeId);
    }

    public static function updateHike(array $newData): void
    {
        $hikesModel = new Hikes();
        $hikeId = $newData['hikeId'] ?? null;
        if ($hikeId) {
            // Print out the $newData array
            error_log(print_r($newData, true));
            $hikesModel->updateHikeById($hikeId, $newData);
        } else {
            // Handle the error, e.g., throw an exception
            throw new \Exception("No hikeId provided");
        }
    }

    public static function getHikeById(int $hikeId): ?array
    {
        $hikesModel = new Hikes();
        return $hikesModel->getHikeById($hikeId);
    }
// Add the addHike method
    public static function addHike(array $hikeData): void
    {
        $hikesModel = new Hikes();

        // Get the user ID from the session
        $userId = $_SESSION['id'] ?? null;
        if (!$userId) {
            throw new \Exception("User is not logged in");
        }

        // Add the user ID to the hike data
        $hikeData['user_id'] = $userId;

        // Validation on $hikeData
         if (empty($hikeData['name'])) {
             throw new \Exception("Hike name is required");
         }

        if (Hikes::addHike($hikeData)) {
            // Hike was successfully added
        } else {
            throw new \Exception("Failed to add hike");
        }
    }
    public static function getAllHikes(): array
    {
        $hikesModel = new Hikes();
        return $hikesModel->getAllHikes();
    }
}
