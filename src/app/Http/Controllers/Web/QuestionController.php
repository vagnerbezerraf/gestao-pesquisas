<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Services\QuestionService;
use App\Services\SurveyService;

class QuestionController extends Controller
{
    protected QuestionService $service;
    protected SurveyService $surveyService;

    public function __construct(QuestionService $service, SurveyService $surveyService)
    {
        $this->service = $service;
        $this->surveyService = $surveyService;
        $this->middleware('auth');
        $this->authorizeResource(\App\Models\Question::class, 'question');
    }

    public function index()
    {
        $questions = $this->service->all();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $surveys = $this->surveyService->all();
        return view('questions.create', compact('surveys'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('questions.index');
    }

    public function show(int $id)
    {
        $question = $this->service->find($id);
        return view('questions.show', compact('question'));
    }

    public function edit(int $id)
    {
        $question = $this->service->find($id);
        $surveys = $this->surveyService->all();
        return view('questions.edit', compact('question', 'surveys'));
    }

    public function update(UpdateQuestionRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('questions.show', $id);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('questions.index');
    }
}
