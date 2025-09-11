<?php

    if (!function_exists('generateImageFile')) {
        /**
         * Method for generating an image file from a base64-encoded file.
         */
        function generateImageFile($base64Image)
        {
            // Extract image type and decode Base64
            $imageParts = explode(';base64,', $base64Image);
            $imageTypeAux = explode('image/', $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $decodedImage = base64_decode($imageParts[1]);

            // Generate unique filename
            $fileName = 'images/' . Str::random(15) . '.' . $imageType;

            // Store the image in the 'public' disk
            Storage::disk('public')->put($fileName, $decodedImage);

            // Get the public URL of the stored image
            $imageUrl = asset('storage/' . $fileName); 

            return $imageUrl;
        }
    }