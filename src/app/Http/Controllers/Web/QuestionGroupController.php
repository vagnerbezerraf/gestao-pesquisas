<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionGroupRequest;
use App\Http\Requests\UpdateQuestionGroupRequest;
use App\Services\QuestionGroupService;
use App\Models\QuestionGroup;

class QuestionGroupController extends Controller
{
    protected QuestionGroupService $service;

    public function __construct(QuestionGroupService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->authorizeResource(QuestionGroup::class, 'question_group');
    }

    public function index()
    {
        $questionGroups = $this->service->all();
        return view('question-groups.index', compact('questionGroups'));
    }

    public function create()
    {
        return view('question-groups.create');
    }

    public function store(StoreQuestionGroupRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('question-groups.index');
    }

    public function show(int $id)
    {
        $questionGroup = $this->service->find($id);
        return view('question-groups.show', compact('questionGroup'));
    }

    public function edit(int $id)
    {
        $questionGroup = $this->service->find($id);
        return view('question-groups.edit', compact('questionGroup'));
    }

    public function update(UpdateQuestionGroupRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('question-groups.show', $id);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('question-groups.index');
    }
}
