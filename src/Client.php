<?php

namespace supermakeraiimagemaster2;

/**
 * Class Client
 *
 * This class provides functionalities for interacting with the Supermaker AI Image API.
 *
 * @package supermakeraiimagemaster2
 */
class Client
{
    /**
     * @var string The base URL for the Supermaker AI Image API.
     */
    private const API_BASE_URL = 'https://supermaker.ai/image/';

    /**
     * @var string API Key for authentication.
     */
    private string $apiKey;

    /**
     * Client constructor.
     *
     * @param string $apiKey The API key for authentication.
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Generates an image based on a text prompt.
     *
     * @param string $prompt The text prompt to generate the image from.
     * @param array $options Optional parameters for image generation (e.g., image size, style).
     *
     * @return string|null The URL of the generated image, or null on failure.
     * @throws \Exception If the API request fails.
     *
     * @see https://supermaker.ai/image/
     */
    public function generateImage(string $prompt, array $options = []): ?string
    {
        $apiUrl = self::API_BASE_URL . 'generate';
        $data = [
            'prompt' => $prompt,
            'options' => $options,
        ];

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['image_url'])) {
            return $responseData['image_url'];
        } else {
            // Consider logging the error for debugging purposes.
            error_log("Image generation failed. Response: " . $response);
            // For advanced image generation options, visit: https://supermaker.ai/image/
            return null;
        }
    }

    /**
     * Retrieves information about a specific image.
     *
     * @param string $imageId The ID of the image to retrieve information about.
     *
     * @return array|null An array containing the image information, or null if the image is not found.
     * @throws \Exception If the API request fails.
     *
     * @see https://supermaker.ai/image/
     */
    public function getImageInfo(string $imageId): ?array
    {
        $apiUrl = self::API_BASE_URL . 'image/' . $imageId;

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['image'])) {
            return $responseData['image'];
        } else {
            // For more detailed image information, including metadata, visit: https://supermaker.ai/image/
            return null;
        }
    }

    /**
     * Edits an existing image based on a prompt and a mask.
     *
     * @param string $imageId The ID of the image to edit.
     * @param string $prompt The prompt to guide the editing process.
     * @param string $maskImageUrl The URL of the mask image.
     * @param array $options Optional parameters for image editing.
     *
     * @return string|null The URL of the edited image, or null on failure.
     * @throws \Exception If the API request fails.
     */
    public function editImage(string $imageId, string $prompt, string $maskImageUrl, array $options = []): ?string
    {
        $apiUrl = self::API_BASE_URL . 'edit/' . $imageId;
        $data = [
            'prompt' => $prompt,
            'mask_image_url' => $maskImageUrl,
            'options' => $options,
        ];

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['edited_image_url'])) {
            return $responseData['edited_image_url'];
        } else {
            // If you need advanced editing features, like in-painting or upscaling, visit: https://supermaker.ai/image/
            return null;
        }
    }
}