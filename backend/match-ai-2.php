<?php

// Use the Flash model for speed and low cost
define('GOOGLE_AI_STUDIO_GEMINI_API_KEY', '');
define('GOOGLE_AI_STUDIO_GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-pro-preview:generateContent');

function GeminiAi($content)
{
    //Call Http client using post
    $payload = json_encode([
        'contents' => [
            [
                'parts' => [
                    ['text' => $content]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.0, // 0.0 makes the AI deterministic/strict
            'maxOutputTokens' => 10
        ]
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                "x-goog-api-key: " . GOOGLE_AI_STUDIO_GEMINI_API_KEY,
            'method'  => 'POST',
            'content' => $payload,
            'ignore_errors' => true
        ]
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents(GOOGLE_AI_STUDIO_GEMINI_BASE_URL, false, $context);
    if ($result === FALSE) {
        // Handle network error
        return 0;
    }

    $data = json_decode($result, true);
    var_dump($data);
    // Extract the text result
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        return $rawScore = trim($data['candidates'][0]['content']['parts'][0]['text']);
        // Ensure we only get numbers (removes any accidental text)
        // return (int) filter_var($rawScore, FILTER_SANITIZE_NUMBER_INT);
    }

    return 0; // Default to 0 on error
}


// --- TEST CASES (Based on your requests) ---

$tests = [
    ["A black gucci bag", "A black gucci bag."], // Expect ~100
    ["A black gucci bag", "A black gucci bag."], // Expect ~100
    // ["A black gucci bag", "A yellow gucci bag"], // Expect ~0-10 (Generative knows colors don't match)
    // Expect ~0-10
];

echo "--- Smart Similarity Results ---\n";

foreach ($tests as $test) {
    // $score = GeminiAi("Come up with a percentage score based on how similar they are. Description A: " . $test[0] . " Description B: " . $test[1]);
    $score = GeminiAi("Give me description about the movie The avengers");
    // echo "A: {$test[0]}\n";
    // echo "B: {$test[1]}\n";
    echo "Score: {$score}";
    // echo "------------------------------\n";
}
