<?php

require_once 'src/models/Database.php';

use Models\Database;

$db = new Database();

// Define the tags array
$tags = ['Hard', 'Rocks', 'Forest', 'Historical'];

// Create placeholders for the IN clause
$placeholders = implode(',', array_fill(0, count($tags), '?'));

// Insert the tags into the Tags table
foreach ($tags as $tag) {
    $db->query("INSERT INTO Tags (name) VALUES (:name)", ['name' => $tag]);
}

// Retrieve the IDs of the newly inserted tags
$tagIds = $db->query("SELECT ID FROM Tags WHERE name IN ($placeholders)", $tags)->fetchAll(PDO::FETCH_COLUMN);

// Use these IDs to insert data into the HikeTags table
for ($i = 1; $i <= 8; $i++) {
    $tagId = $tagIds[($i - 1) % count($tagIds)];
    $db->query("INSERT INTO HikeTags (hike_id, tag_id) VALUES (:hike_id, :tag_id)", ['hike_id' => $i, 'tag_id' => $tagId]);
}INSERT INTO hikes (name) VALUES ('Rome');
