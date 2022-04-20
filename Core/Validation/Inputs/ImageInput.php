<?php

namespace Core\Validation\Inputs;

/**
 * The class that represents an image input.
 */
final class ImageInput extends Input
{
    /**
     * @var array The image to validate.
     */
    private array $img;

    /**
     * Initializes a new instance of the ImageInput class.
     * 
     * @param string $name The input's name.
     * @param array $img The image to validate.
     */
    public function __construct(string $name, array $img)
    {
        parent::__construct($name);

        $this->img = $img;
    }

    /**
     * Conditions checked:
     * - Image exists
     * - Image meets size constraints
     * - If the image has any errors.
     * 
     * @return string An error message if invalid, empty string if valid.
     */
    public function validateInput(): string
    {
        $msg = '';

        if (empty($this->img) || !$this->isImage($this->img['type'])) {
            $msg = $this->formatError('Please enter an image');
        }
        else if (filesize($this->img['tmp_name']) > MAX_FILE_SIZE) {
            $msg = $this->formatError('File size must be below ' . MAX_FILE_SIZE . ' bytes');
        }
        else if ($this->img['error'] != 0) {
            $msg = $this->formatError('There was a problem uploading your image.');
        }

        return $msg;
    }

    /**
     * Determines if the provided type is an image.
     * 
     * @param string $type The type to verify.
     * @return bool Whether the type was an image or not.
     */
    private function isImage(string $type): bool
    {
        return explode('/', $type)[0] == 'image';
    }
}
