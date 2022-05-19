<?php

namespace Core\Validation\Inputs;

/**
 * The class that represents a text input.
 * 
 * @param PreussenKaiser
 */
final class TextInput extends Input
{
    /**
     * The input's value.
     * @param string
     */
    private readonly string $value;

    /**
     * The maximum amount of characters allowed.
     * @var int
     */
    private readonly int $max_char;

    /**
     * Initializes a new instance of the TextInput input.
     * 
     * @param string $name The name of the input.
     * @param string $value The input's value.
     * @param int $max_char The maximum amount of characters allowed.
     */
    public function __construct(string $name, string $value,
                                int $max_char = 65535)
    {
        parent::__construct($name);

        $this->value = $value;
        $this->max_char = $max_char;
    }

    /**
	 * Validates the text input.
	 *
	 * @return string An error message if invalid, 
     *                empty string if valid.
	 */
	public function validateInput(): string
    {
        return 
            strlen($this->value) > 0 && strlen($this->value) <= $this->max_char
            ? ''
            : $this->formatError(
                "Input must be between 0 and $this->max_char characters in length"
            );
    }
}
