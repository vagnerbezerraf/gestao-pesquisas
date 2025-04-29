<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnswerRequest;
use App\Services\AnswerService;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;

class AnswerController extends Controller
{
    protected AnswerService $service;

    public function __construct(AnswerService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->authorizeResource(\App\Models\Answer::class, 'answer');
    }

    public function index(Request $request)
    {
        // Aplica filtros de pesquisa e pergunta
        $query = Answer::with('survey','question','user');
        if ($request->filled('survey_id')) {
            $query->where('survey_id', $request->survey_id);
        }
        if ($request->filled('question_id')) {
            $query->where('question_id', $request->question_id);
        }
        $answers = $query->get();
        $surveys = Survey::pluck('title','id');
        $questions = Question::pluck('text','id');
        return view('answers.index', compact('answers','surveys','questions'));
    }

    public function create()
    {
        return view('answers.create');
    }

    public function store(StoreAnswerRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('answers.index');
    }

    public function show(int $id)
    {
        $answer = $this->service->find($id);
        return view('answers.show', compact('answer'));
    }

    public function edit(int $id)
    {
        $answer = $this->service->find($id);
        return view('answers.edit', compact('answer'));
    }

    public function update(StoreAnswerRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('answers.show', $id);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('answers.index');
    }
}
