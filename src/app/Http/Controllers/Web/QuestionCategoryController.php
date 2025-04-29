<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionCategoryRequest;
use App\Http\Requests\UpdateQuestionCategoryRequest;
use App\Services\QuestionCategoryService;
use App\Models\QuestionCategory;

class QuestionCategoryController extends Controller
{
    protected QuestionCategoryService $service;

    public function __construct(QuestionCategoryService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->authorizeResource(QuestionCategory::class, 'question_category');
    }

    public function index()
    {
        $categories = $this->service->all();
        return view('question-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('question-categories.create');
    }

    public function store(StoreQuestionCategoryRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('question-categories.index');
    }

    public function show(QuestionCategory $question_category)
    {
        $category = $this->service->find($question_category->id);
        return view('question-categories.show', compact('category'));
    }

    public function edit(QuestionCategory $question_category)
    {
        $category = $this->service->find($question_category->id);
        return view('question-categories.edit', compact('category'));
    }

    public function update(UpdateQuestionCategoryRequest $request, QuestionCategory $question_category)
    {
        $this->service->update($question_category->id, $request->validated());
        return redirect()->route('question-categories.show', $question_category->id);
    }

    public function destroy(QuestionCategory $question_category)
    {
        $this->service->delete($question_category->id);
        return redirect()->route('question-categories.index');
    }
}
