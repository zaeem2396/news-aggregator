<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    protected $articles;
    public function __construct(Articles $articles)
    {
        $this->articles = $articles;
    }
    public function fetchArticle(Request $request)
    {
        try {
            $inputData = $request->only('s', 'fromDate', 'toDate', 'source_name', 'section', 'perPage');

            $validator = Validator::make($inputData, [
                's' => 'nullable|string',
                'fromDate' => 'nullable|date',
                'toDate' => 'nullable|date',
                'source_name' => 'nullable|string',
                'section' => 'nullable|string',
                'perPage' => 'nullable|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 422);
            }
            // Fetch Articles
            $articles = $this->articles->getArticles($inputData);
            return response()->json($articles);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
