<?php

namespace App\Traits;

trait HandlesRichTextAttributes
{
    /**
     * Set the description attribute.
     * Deletes rich text if the value is null or empty after stripping tags.
     */
    public function setDescriptionAttribute($value)
    {
        if (isset($this->attributes['description']) && (is_null($value) || trim(strip_tags($value)) === '')) {
            $this->richTextDescription()?->delete();
            return;
        }
        $this->attributes['description'] = $value;
    }

    /**
     * Set the notes attribute.
     * Deletes rich text if the value is null or empty after stripping tags.
     */
    public function setNotesAttribute($value)
    {
        if (isset($this->attributes['notes']) && (is_null($value) || trim(strip_tags($value)) === '')) {
            $this->richTextNotes()?->delete();
            return;
        }
        $this->attributes['notes'] = $value;
    }

    /**
     * Set the address attribute.
     * Deletes rich text if the value is null or empty after stripping tags.
     */
    public function setAddressAttribute($value)
    {
        if (isset($this->attributes['address']) && (is_null($value) || trim(strip_tags($value)) === '')) {
            $this->richTextAddress()?->delete();
            return;
        }
        $this->attributes['address'] = $value;
    }

    /**
     * Set the review attribute.
     * Deletes rich text if the value is null or empty after stripping tags.
     */
    public function setReviewAttribute($value)
    {
        if (isset($this->attributes['review']) && (is_null($value) || trim(strip_tags($value)) === '')) {
            $this->richTextReview()?->delete();
            return;
        }
        $this->attributes['review'] = $value;
    }

    /**
     * Set the nearby_attractions attribute.
     * Deletes rich text if the value is null or empty after stripping tags.
     */
    public function setNearbyAttractionsAttribute($value)
    {
        if (isset($this->attributes['nearby_attractions']) && (is_null($value) || trim(strip_tags($value)) === '')) {
            $this->richTextNearbyAttractions()?->delete();
            return;
        }
        $this->attributes['nearby_attractions'] = $value;
    }
}
