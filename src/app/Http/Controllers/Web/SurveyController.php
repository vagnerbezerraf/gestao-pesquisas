<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SurveyService;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function __construct(SurveyService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->authorizeResource(Survey::class, 'survey');
    }

    public function index()
    {
        $surveys = $this->service->all();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        $groups = QuestionCategory::with('questions')->get();
        return view('surveys.create', compact('groups'));
    }

    public function store(StoreSurveyRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('surveys.index');
    }

    public function show(Survey $survey)
    {
        $survey = $this->service->find($survey->id);
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $survey = $this->service->find($survey->id);
        $groups = QuestionCategory::with('questions')->get();
        return view('surveys.edit', compact('survey', 'groups'));
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $this->service->update($survey->id, $request->validated());
        return redirect()->route('surveys.show', $survey->id);
    }

    /**
     * Show the survey configuration screen.
     */
    public function configure()
    {
        $this->authorize('viewAny', Survey::class);
        $surveys = Survey::with('questions')->get();
        $groups = QuestionCategory::with('questions')->get();
        return view('surveys.configure', compact('surveys', 'groups'));
    }

    /**
     * Save survey-question associations.
     */
    public function configureSave(Request $request)
    {
        $data = $request->validate(
            [
                'survey_id' => 'required|exists:surveys,id',
                'questions' => 'required|array|min:1',
                'questions.*' => 'exists:questions,id',
            ],
            [
                'survey_id.required' => 'Selecione uma pesquisa.',
                'questions.required' => 'Selecione pelo menos uma pergunta.',
            ]
        );
        $survey = Survey::findOrFail($data['survey_id']);
        $this->authorize('update', $survey);
        $survey->questions()->sync($data['questions'] ?? []);
        return redirect()->route('surveys.configure', ['survey_id' => $data['survey_id']])->with('success', 'Associação atualizada.');
    }

    public function destroy(Survey $survey)
    {
        $this->service->delete($survey->id);
        return redirect()->route('surveys.index');
    }
}
