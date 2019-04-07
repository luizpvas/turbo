<?php

namespace App\Models;

use App\Models\Traits\WebsiteScoped;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use WebsiteScoped;

    /**
     * Disable mass assignment exceptions.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Checks if this attachment is an image.
     *
     * @return boolean.
     */
    function isImage()
    {
        return in_array($this->mime, [
            'image/svg+xml',
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/gif'
        ]);
    }

    /**
     * Returns the letter shown in the preview when
     * the attachment is not an image.
     *
     * @return string
     */
    function preview()
    {
        $parts = explode(".", $this->name);

        if (count($parts) == 2) {
            return $parts[1];
        }

        return __('FILE');
    }
}
