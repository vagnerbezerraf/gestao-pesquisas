<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Services\GroupService;
use App\Models\Group;

class GroupController extends Controller
{
    protected GroupService $service;

    public function __construct(GroupService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->authorizeResource(Group::class, 'group');
    }

    public function index()
    {
        $groups = $this->service->all();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(StoreGroupRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('groups.index');
    }

    public function show(int $id)
    {
        $group = $this->service->find($id);
        return view('groups.show', compact('group'));
    }

    public function edit(int $id)
    {
        $group = $this->service->find($id);
        return view('groups.edit', compact('group'));
    }

    public function update(StoreGroupRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('groups.show', $id);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('groups.index');
    }
}
