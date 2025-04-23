<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SurveyService;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;

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
        return view('surveys.create');
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
        return view('surveys.edit', compact('survey'));
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $this->service->update($survey->id, $request->validated());
        return redirect()->route('surveys.show', $survey->id);
    }

    public function destroy(Survey $survey)
    {
        $this->service->delete($survey->id);
        return redirect()->route('surveys.index');
    }
}
