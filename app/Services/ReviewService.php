<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function __construct()
    {
        //
    }

    public function setProperties(Review $review, array $properties): void
    {
        if (!empty($properties['id_client'])) {
            $review->id_client = $properties['id_client'];
        }

        if (!empty($properties['id_carte'])) {
            $review->id_carte = $properties['id_carte'];
        }

        if (!empty($properties['comentariu'])) {
            $review->comentariu = $properties['comentariu'];
        }

        if (!empty($properties['rating'])) {
            $review->rating = $properties['rating'];
        }

        if (!empty($properties['data_review'])) {
            $review->data_review = $properties['data_review'];
        }

        if (!empty($properties['titlu'])) {
            $review->titlu = $properties['titlu'];
        }
    }
}
