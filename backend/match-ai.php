<?php

// Use the Flash model for speed and low cost
define('GOOGLE_AI_STUDIO_GEMINI_API_KEY', 'AIzaSyCs7u4RfkNahQiOCLuiYyMYs6EMN_AcslE');
define('GOOGLE_AI_STUDIO_GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent');

/**
 * Calculates a similarity score using Generative AI Reasoning.
 * * @param string $itemA The first item description.
 * @param string $itemB The second item description.
 * @return int The percentage score (0-100).
 */
function getSmartSimilarityScore($itemA, $itemB)
{
    // We craft a prompt that forces the AI to act as a judge, not just a text comparator.
    $prompt = <<<EOT
    Act as a strict Lost and Found Matcher. Compare the following two item descriptions and provide a match percentage score from 0 to 100.
    
    Description A: "$itemA"
    Description B: "$itemB"
    
    Scoring Rules:
    1. EXACT MATCH: If specific details (Brand, Color, Item Type) match perfectly, score 95-100.
    2. FATAL MISMATCH: If the Item Type is different (e.g., Bag vs Person) OR the Color is clearly different (e.g., Black vs Yellow), score 0-10.
    3. VAGUE MATCH: If one is generic ("Bag") and one is specific ("Gucci Bag"), score 50-75 based on likelihood.
    4. TYPOS: Ignore spelling errors.
    
    CRITICAL: Return ONLY the integer number. Do not explain. Do not use markdown.
    EOT;

    $payload = json_encode([
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
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
        $rawScore = trim($data['candidates'][0]['content']['parts'][0]['text']);
        // Ensure we only get numbers (removes any accidental text)
        return (int) filter_var($rawScore, FILTER_SANITIZE_NUMBER_INT);
    }

    return 0; // Default to 0 on error
}

// --- TEST CASES (Based on your requests) ---

$tests = [
    ["A black gucci bag", "A black gucci bag."], // Expect ~100
    ["A black gucci bag", "A yellow gucci bag"], // Expect ~0-10 (Generative knows colors don't match)
    ["A black gucci bag", "blue pouch"],         // Expect ~20-40
    ["white earpiece", "some stuff we saw"]      // Expect ~0-10
];

echo "--- Smart Similarity Results ---\n";

foreach ($tests as $test) {
    $score = getSmartSimilarityScore($test[0], $test[1]);
    echo "A: {$test[0]}\n";
    echo "B: {$test[1]}\n";
    echo "Score: {$score}%\n";
    echo "------------------------------\n";
}
