<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NSFWController extends Controller
{

    public static function detect($path) {
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://nsfw3.p.rapidapi.com/v1/results', [
                'multipart' => [
                    [
                        'name' => 'image', // This should match the expected field name in the API
                        'contents' => fopen($path, 'r'),
                        'filename' => basename($path), // Use the original filename
                    ],
                ],
                'headers' => [
                    'x-rapidapi-host' => 'nsfw3.p.rapidapi.com',
                    'x-rapidapi-key' => '15270d34edmsh3026918dd2ce444p1e9df9jsn783e21c27799', // Replace with your actual API key
                ],
            ]);
    
            $result = json_decode($response->getBody(), true);
            return ['safe' => $result["results"][0]["entities"][0]["classes"]["nsfw"] < 0.7];
        } catch(\Exception $e) {
            Log::error('Request failed: ' . $e->getMessage());
            return ['safe' => true];
        }
    }
    public static function detectOLD2($image, $path)
    {
        // Validate and get the uploaded image
        if ($image) {
            $imagePath = $path;
            $imageUrl = url($path);
            Log::info("FIle paht: $path");
            // Set up GuzzleHTTP client
            $client = new Client();

            try {
                $response = $client->request('POST', 'https://nsfw-images-detection-ai.p.rapidapi.com/nsfw-from-file', [
                    'multipart' => [
                        [
                            'name' => 'mask_shape',
                            'contents' => 'Rectangle border'
                        ],
                        [
                            'name' => 'fill_color',
                            'contents' => 'red'
                        ],
                        [
                            'name' => 'rectangle_border_width',
                            'contents' => '5'
                        ],
                        [
                            'name' => 'filter_type',
                            'contents' => 'Fill color'
                        ],
                        [
                            'name' => 'image',
                            'contents' => fopen($path, 'r'),
                            'filename' => basename($path), // Changed to use just the filename
                        ]
                    ],
                    'headers' => [
                        'x-rapidapi-host' => 'nsfw-images-detection-ai.p.rapidapi.com',
                        'x-rapidapi-key' => '15270d34edmsh3026918dd2ce444p1e9df9jsn783e21c27799', // Replace with your actual API key
                    ],
                ]);

                // Get the response
                $result = json_decode($response->getBody(), true);
                return ['result' => $result];
            } catch (\Exception $e) {
                return ['error' => 'Request failed: ' . $e->getMessage()];
            }
        }

        return ['error' => 'No image provided'];
    }
    public static function oldCode($image, $path)
    {
        // Validate and get the uploaded image
        if ($image) {
            $imagePath = $path;
            Log::info("Image Path is : $path");
            // Set up GuzzleHTTP client
            $client = new Client();

            $response = $client->request('POST', 'https://nsfw-images-detection-ai.p.rapidapi.com/nsfw-from-file', [
                'multipart' => [
                    [
                        'name' => 'mask_shape',
                        'contents' => 'Rectangle border'
                    ],
                    [
                        'name' => 'fill_color',
                        'contents' => 'red'
                    ],
                    [
                        'name' => 'rectangle_border_width',
                        'contents' => '5'
                    ],
                    [
                        'name' => 'filter_type',
                        'contents' => 'Fill color'
                    ],
                    [
                        'name' => 'image',
                        'contents' => fopen($path, 'r'),
                        'filename' => $imagePath,
                    ]
                ],
                'headers' => [
                    'x-rapidapi-host' => 'nsfw-images-detection-ai.p.rapidapi.com',
                    'x-rapidapi-key' => '15270d34edmsh3026918dd2ce444p1e9df9jsn783e21c27799',
                ],
            ]);

            // Get the response
            $result = json_decode($response->getBody(), true);
            return ['result' => response()->json($result)];
        }

        return ['error' => 'No image provided'];
    }
}
