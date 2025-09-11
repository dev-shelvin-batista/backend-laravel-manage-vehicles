<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Image implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the value is a valid base64 string
        if (! preg_match('/^data:image\/(png|jpeg|gif);base64,/', $value)) {
            return false;
        }

        // Extract the base64 data part
        list($type, $data) = explode(';', $value);
        list(, $data)      = explode(',', $data);

        // Decode the base64 string
        $decodedImage = base64_decode($data);

        // Check if decoding was successful and it's a valid image
        if (! $decodedImage) {
            return false;
        }

        // Optionally, check image type and size
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $decodedImage);
        finfo_close($finfo);

        if (! in_array($mimeType, ['image/png', 'image/jpeg', 'image/gif'])) {
            return false;
        }

        // Example: Max size of 100MB (2 * 1024 * 1024 bytes)
        if (strlen($decodedImage) > 100 * 1024 * 1024) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute must be a valid base64 encoded image (PNG, JPEG, GIF) with a maximum size of 2MB.';
    }
}
