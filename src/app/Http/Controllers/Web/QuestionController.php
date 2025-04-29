<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Services\QuestionService;
use App\Services\QuestionCategoryService;
use App\Models\Question;

class QuestionController extends Controller
{
    protected QuestionService $service;
    protected QuestionCategoryService $categoryService;

    public function __construct(QuestionService $service, QuestionCategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
        $this->middleware('auth');
        $this->authorizeResource(Question::class, 'question', ['except' => ['edit', 'update']]);
    }

    public function index()
    {
        $questions = $this->service->all();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $categories = $this->categoryService->all();
        return view('questions.create', compact('categories'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('questions.index');
    }

    public function show(Question $question)
    {
        $question = $this->service->find($question->id);
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $question = $this->service->find($question->id);
        $categories = $this->categoryService->all();
        return view('questions.edit', compact('question', 'categories'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $this->service->update($question->id, $request->validated());
        return redirect()->route('questions.show', $question->id);
    }

    public function destroy(Question $question)
    {
        $this->service->delete($question->id);
        return redirect()->route('questions.index');
    }
}
