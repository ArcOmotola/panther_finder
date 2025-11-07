<?php
require_once('../../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
$db = new Database();

#gemini_api_key
define('GOOGLE_AI_STUDIO_GEMINI_API_KEY', '');
define('GOOGLE_AI_STUDIO_GEMINI_MODEL', 'gemini-2.0-flash');
define('GOOGLE_AI_STUDIO_GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent');



// --- Input Sentences ---
$sentenceA = "The fast automobile accelerated quickly on the asphalt road.";
$sentenceB = "A rapid car sped up fast on the tarmac.";
// Expected result: High similarity (paraphrases)

/**
 * Step 1: Call the Gemini API to get the embedding vector for a single sentence.
 * @param string $text The sentence to embed.
 * @param string $endpoint The embedding API URL.
 * @return array The embedding vector (list of floats).
 */
function getEmbedding($text)
{

    $payload = json_encode([
        'model' => 'gemini-embedding-001',
        'content' => [
            'parts' => [['text' => $text]]
        ],
        // Important: Specify the task type for optimal comparison
        'config' => ['taskType' => 'SEMANTIC_SIMILARITY']
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                "x-goog-api-key: " . GOOGLE_AI_STUDIO_GEMINI_API_KEY,
            'method'  => 'POST',
            'content' => $payload,
            'ignore_errors' => true // Allows reading the body on error
        ]
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents(GOOGLE_AI_STUDIO_GEMINI_BASE_URL, false, $context);

    if ($result === FALSE) {
        die("Error fetching embedding from API.\n");
    }

    $data = json_decode($result, true);

    // Check for API errors
    if (isset($data['error'])) {
        die("API Error: " . $data['error']['message'] . "\n");
    }

    // Extract the embedding vector (the long list of numbers)
    return $data['embedding']['values'] ?? [];
}


/**
 * Step 2: Calculate the Cosine Similarity between two vectors.
 * This measures the angle between them (closer to 1.0 means higher similarity).
 * @param array $vecA First embedding vector.
 * @param array $vecB Second embedding vector.
 * @return float Cosine similarity score (between -1.0 and 1.0).
 */
function cosineSimilarity(array $vecA, array $vecB)
{
    if (count($vecA) !== count($vecB) || empty($vecA)) {
        return 0.0;
    }

    $dotProduct = 0.0;
    $magnitudeA = 0.0;
    $magnitudeB = 0.0;

    // Calculate Dot Product (A * B) and Magnitudes (||A|| and ||B||)
    for ($i = 0; $i < count($vecA); $i++) {
        $dotProduct += $vecA[$i] * $vecB[$i];
        $magnitudeA += $vecA[$i] * $vecA[$i]; // Sum of squares for A
        $magnitudeB += $vecB[$i] * $vecB[$i]; // Sum of squares for B
    }

    $magnitudeA = sqrt($magnitudeA);
    $magnitudeB = sqrt($magnitudeB);

    // Check for division by zero
    if ($magnitudeA == 0.0 || $magnitudeB == 0.0) {
        return 0.0;
    }

    // Formula: (A * B) / (||A|| * ||B||)
    return $dotProduct / ($magnitudeA * $magnitudeB);
}


// --- Execution ---
echo "Comparing Sentences:\n";
echo "A: " . $sentenceA . "\n";
echo "B: " . $sentenceB . "\n\n";

// 1. Get Embeddings
echo "Fetching embedding for Sentence A...\n";
$embeddingA = getEmbedding($sentenceA);
echo "Fetching embedding for Sentence B...\n";
$embeddingB = getEmbedding($sentenceB);

// Check if embeddings were retrieved successfully
if (empty($embeddingA) || empty($embeddingB)) {
    die("Could not retrieve one or both embeddings. Check API key and network connection.\n");
}

// 2. Calculate Similarity Score
$similarityScore = cosineSimilarity($embeddingA, $embeddingB);

// 3. Convert to Percentage
$accuracyPercentage = round($similarityScore * 100, 2);

echo "\n--- Results ---\n";
echo "Cosine Similarity Score (0.0 to 1.0): " . number_format($similarityScore, 4) . "\n";
echo "Semantic Accuracy Percentage: **" . $accuracyPercentage . "%**\n";
echo "-----------------\n";
