<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InviteService;
use App\Services\SurveyService;
use App\Services\GroupService;
use App\Http\Requests\StoreInviteRequest;
use App\Models\Invite;

class InviteController extends Controller
{
    protected InviteService $service;
    protected SurveyService $surveyService;
    protected GroupService $groupService;

    public function __construct(InviteService $service, SurveyService $surveyService, GroupService $groupService)
    {
        $this->service = $service;
        $this->surveyService = $surveyService;
        $this->groupService = $groupService;
        $this->middleware('auth');
        $this->authorizeResource(Invite::class, 'invite');
    }

    public function index()
    {
        $invites = $this->service->all();
        return view('invites.index', compact('invites'));
    }

    public function create()
    {
        $surveys = $this->surveyService->all();
        $groups = $this->groupService->all();
        return view('invites.create', compact('surveys', 'groups'));
    }

    public function store(StoreInviteRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('invites.index');
    }

    public function show(int $id)
    {
        $invite = $this->service->find($id);
        return view('invites.show', compact('invite'));
    }

    public function edit(int $id)
    {
        $invite = $this->service->find($id);
        $surveys = $this->surveyService->all();
        $groups = $this->groupService->all();
        return view('invites.edit', compact('invite', 'surveys', 'groups'));
    }

    public function update(StoreInviteRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('invites.show', $id);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('invites.index');
    }

    public function send(int $id)
    {
        $this->service->send($id);
        return redirect()->back();
    }
}
