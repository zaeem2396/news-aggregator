<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'section', 'author', 'description', 'content', 'url', 'image_url', 'source_name', 'published_at'];
    public $timestamps = false;

    /**
     * Fetch articles based on filters and paginate the results.
     *
     * @param array $inputData
     * @return array
     */
    public function getArticles(array $inputData)
    {
        $query = self::query();

        // Dynamic search filters
        if (!empty($inputData['s'])) {
            $query->where(function (Builder $q) use ($inputData) {
                $q->where('title', 'like', '%' . $inputData['s'] . '%')
                    ->orWhere('description', 'like', '%' . $inputData['s'] . '%')
                    ->orWhere('content', 'like', '%' . $inputData['s'] . '%');
            });
        }

        // from date filters
        if (!empty($inputData['fromDate'])) {
            $query->where('published_at', '>=', $inputData['fromDate']);
        }
        // to date filter
        if (!empty($inputData['toDate'])) {
            $query->where('published_at', '<=', $inputData['toDate']);
        }

        // If date is not passed fetch today's records by default 
        if (empty($inputData['fromDate']) && empty($inputData['toDate'])) {
            // $today = Carbon::today()->format('Y-m-d');
            // $query->where('published_at', 'like', '%' . $today . '%');
            $query->orderBy('published_at', 'desc');
        }

        // Additional filters
        if (!empty($inputData['source_name'])) {
            $query->where('source_name', 'like', '%' . $inputData['source_name'] . '%');
        }

        if (!empty($inputData['section'])) {
            $query->where('section', 'like', '%' . $inputData['section'] . '%');
        }

        // Pagination
        $perPage = $inputData['perPage'] ?? 10;
        $page = $inputData['page'] ?? 1;

        $pagination = $query->paginate($perPage, ['*'], 'page', $page);

        // Prepare the response
        return [
            'totalRecords' => $pagination->total(),
            'totalPages' => $pagination->lastPage(),
            'currentPage' => $pagination->currentPage(),
            'perPage' => $pagination->perPage(),
            'records' => $pagination->items(),
        ];
    }
}
