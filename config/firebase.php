<?php

return [
    'credentials' => [
        'path' => base_path("firebaseServiceAccountKey.json"),
    ],
    'database_uri' => env('FIREBASE_DATABASE_URL', 'https://social-media-project-52817-default-rtdb.firebaseio.com/'),
    'project_id' => env('FIREBASE_PROJECT_ID', 'social-media-project-52817'),
];
