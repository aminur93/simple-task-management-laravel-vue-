<?php

namespace App\Http\Services\Api\V1\Admin\Task;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TaskInterface
{
    public function index(Request $request);

    public function getAllTasks();

    public function store(Request $request);

    public function show(int $id);

    public function update(Request $request, int $id);

    public function destroy(int $id);

    public function changeStatus(Request $request, int $id);

    public function changeCompleteStatus(Request $request, int $id);
}