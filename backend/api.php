<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

class CoachAPI {
    private $coaches = [
        [
            'id' => 1,
            'name' => 'John Smith',
            'location' => 'New York',
            'country' => 'United States',
            'hourlyRate' => 85,
            'expertise' => ['Groundstrokes', 'Volleys', 'Smash'],
            'rating' => 4.55
        ],
        [
            'id' => 2,
            'name' => 'Sarah Johnson',
            'location' => 'San Francisco',
            'country' => 'United States',
            'hourlyRate' => 95,
            'expertise' => ['Serve', 'Groundstrokes', 'Smash', 'Strength'],
            'rating' => 4.75
        ],
        [
            'id' => 3,
            'name' => 'Michael Chen',
            'location' => 'Tokyo',
            'country' => 'Japan',
            'hourlyRate' => 175,
            'expertise' => ['Serve', 'Groundstrokes', 'Dexterity','Volleys', 'Smash'],
            'rating' => 4.9
        ],
        [
            'id' => 3,
            'name' => 'John Mckee',
            'location' => 'New York',
            'country' => 'Unites States',
            'hourlyRate' => 145,
            'expertise' => ['Serve', 'Volleys', 'Smash','Stamina'],
            'rating' => 4.8
        ]
    ];

    public function getCoaches() {
        $filteredCoaches = $this->coaches;
        
        // Filter by name
        if (isset($_GET['name'])) {
          $searchTerm = strtolower($_GET['name'] ?? $_GET['location']);
          $filteredCoaches = array_filter($filteredCoaches, function($coach) use ($searchTerm) {
              return str_contains(strtolower($coach['name']), $searchTerm) || 
                     str_contains(strtolower($coach['location']), $searchTerm);
          });
        }
 
        // Sort by hourly rate
        if (isset($_GET['sort']) && $_GET['sort'] === 'rate') {
            $direction = isset($_GET['direction']) && $_GET['direction'] === 'desc' ? -1 : 1;
            usort($filteredCoaches, function($a, $b) use ($direction) {
                return ($a['hourlyRate'] - $b['hourlyRate']) * $direction;
            });
        }

        return [
            'status' => 'success',
            'count' => count($filteredCoaches),
            'data' => array_values($filteredCoaches)
        ];
    }

    public function handleRequest() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                echo json_encode($this->getCoaches());
                break;
            default:
                http_response_code(405);
                echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
                break;
        }
    }
}

$api = new CoachAPI();
$api->handleRequest();




