<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InviteService;
use App\Services\SurveyService;
use App\Services\GroupService;
use App\Http\Requests\StoreInviteRequest;
use App\Models\Invite;
use Illuminate\Support\Facades\Log;

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

    public function index(Request $request)
    {
        $surveys = $this->surveyService->all();
        $groups  = $this->groupService->all();
        $query   = Invite::with(['survey', 'group']);
        if ($request->filled('survey_id')) {
            $query->where('survey_id', $request->survey_id);
        }
        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }
        $invites = $query->get();
        return view('invites.index', compact('invites', 'surveys', 'groups'));
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

    public function show(Invite $invite)
    {
        $this->authorize('view', $invite);
        $invite = $this->service->find($invite->id);
        return view('invites.show', compact('invite'));
    }

    public function edit(Invite $invite)
    {
        $this->authorize('update', $invite);
        $invite = $this->service->find($invite->id);
        $surveys = $this->surveyService->all();
        $groups = $this->groupService->all();
        return view('invites.edit', compact('invite', 'surveys', 'groups'));
    }

    public function update(StoreInviteRequest $request, Invite $invite)
    {
        $this->authorize('update', $invite);
        $this->service->update($invite->id, $request->validated());
        return redirect()->route('invites.show', $invite->id);
    }

    public function destroy(Invite $invite)
    {
        $this->authorize('delete', $invite);
        $this->service->delete($invite->id);
        return redirect()->route('invites.index');
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $id) {
            $invite = $this->service->find($id);
            $this->authorize('delete', $invite);
            $this->service->delete($id);
        }
        return redirect()->route('invites.index');
    }

    public function massSend(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $id) {
            $invite = $this->service->find($id);
            $this->authorize('update', $invite);
            $this->service->send($invite->id);
        }
        return redirect()->route('invites.index');
    }

    public function send(Invite $invite)
    {
        $this->authorize('update', $invite);
        $sentInvite = $this->service->send($invite->id);
        dd($sentInvite->toArray());
    }
}
