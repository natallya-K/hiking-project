<?php
declare(strict_types=1);

namespace Models;

use PDO;

class Hikes extends Database
{

    public static function getAllNames(int $page = 1, int $itemsPerPage = 6): array
    {
        $database = new self();
        $offset = ($page - 1) * $itemsPerPage;
        $stmt = $database->query("SELECT id, name, distance, duration, elevation_gain, description, created_at, updated_at FROM Hikes LIMIT :limit OFFSET :offset", ['limit' => $itemsPerPage, 'offset' => $offset]);
        $hikes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hikes;
    }

    public static function getTotalHikes(): int
    {
        $database = new Database(); // Create an instance of the Database class
        $stmt = $database->query("SELECT COUNT(*) as total FROM Hikes"); // Call the query method on the instance
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function getHikeById(int $id): array
    {
        $database = new self();
        $stmt = $database->query("SELECT * FROM Hikes WHERE id = :id", ['id' => $id]);
        $hike = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hike;
    }
    public static function getHikeDetails(int $hikeId): ?array
    {
        $database = new self();
        $stmt = $database->query("SELECT * FROM Hikes WHERE id = :id", ['id' => $hikeId]);
        $hike = $stmt->fetch(PDO::FETCH_ASSOC);
        return $hike;
    }
    public static function getHikeTags(int $hikeId): array
    {
        $database = new self();
        $stmt = $database->query("SELECT Tags.tag_name FROM HikeTags INNER JOIN Tags ON HikeTags.tag_id = Tags.ID WHERE HikeTags.hike_id = :id", ['id' => $hikeId]);
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tags;
    }

    public static function getHikesByTag(string $tag, int $page = 1, int $itemsPerPage = 6): array
    {
        $offset = ($page - 1) * $itemsPerPage;
        $database = new self();

        // SQL query to get hikes filtered by tag
        $sql = "SELECT Hikes.* FROM Hikes 
            JOIN HikeTags ON Hikes.id = HikeTags.hike_id 
            JOIN Tags ON HikeTags.tag_id = Tags.ID 
            WHERE Tags.tag_name = :tag 
            LIMIT :offset, :itemsPerPage";

        // Prepare and execute the query
        $stmt = $database->query($sql, [
            ':tag' => $tag,
            ':offset' => $offset,
            ':itemsPerPage' => $itemsPerPage
        ]);

        // Return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getHikesByUser(int $userId): array
    {
        $database = new self();
        $stmt = $database->query("SELECT * FROM Hikes WHERE user_id = :userId", [':userId' => $userId]);
        $hikes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hikes;
    }

    public static function deleteHikeById(int $id): bool
    {
        $database = new self();
        $stmt = $database->query("DELETE FROM Hikes WHERE id = :id", ['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public static function updateHikeById(int $hikeId, array $newData): bool
    {
        $database = new self();

        // Prepare the SQL update statement
        $sql = "UPDATE Hikes SET 
                    name = :name, 
                    distance = :distance, 
                    duration = :duration, 
                    elevation_gain = :elevation_gain, 
                    description = :description, 
                    updated_at = NOW() 
                WHERE id = :id";

        // Bind parameters
        $params = [
            ':id' => $hikeId,
            ':name' => $newData['name'],
            ':distance' => $newData['distance'],
            ':duration' => $newData['duration'],
            ':elevation_gain' => $newData['elevation_gain'],
            ':description' => $newData['description']
        ];

        // Execute the query
        $stmt = $database->query($sql, $params);

        // Return true if the update was successful
        return $stmt->rowCount() > 0;
    }
    public static function addHike(array $hikeData): bool
    {
        $database = new self();

        // Prepare the SQL insert statement
        $sql = "INSERT INTO Hikes (name, distance, duration, elevation_gain, description, user_id, created_at, updated_at, picture_url)
                VALUES (:name, :distance, :duration, :elevation_gain, :description, :user_id, NOW(), NOW(), 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2832&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')";

        // Bind parameters
        $params = [
            ':name' => $hikeData['name'],
            ':distance' => $hikeData['distance'],
            ':duration' => $hikeData['duration'],
            ':elevation_gain' => $hikeData['elevation_gain'],
            ':description' => $hikeData['description'],
            ':user_id' => $hikeData['user_id']
        ];

        // Execute the query
        $stmt = $database->query($sql, $params);

        // Return true if the insert was successful
        return $stmt->rowCount() > 0;
    }
    public static function getAllHikes(): array
    {
        $database = new self();
        $stmt = $database->query("SELECT * FROM Hikes");
        $hikes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hikes;
    }
}
