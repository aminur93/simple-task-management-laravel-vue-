<?php

namespace App\Http\Services\Api\V1\Admin\Task;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class TaskService implements TaskInterface
{
    /**
     * Retrieve all tasks with pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $task = new Task();

        if ($request->has('sortBy') && $request->has('sortDesc')) {

            $sortBy = $request->query('sortBy');

            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';

            $task = $task->orderBy($sortBy, $sortDesc);

        } else {

            $task = $task->orderBy('id', 'desc');
        }

        $searchValue = $request->input('search');
        $itemsPerPage = 10;

        if ($searchValue)
        {
            $task->where(function ($query) use ($searchValue) {
                $query->where('title', 'like', '%' . $searchValue . '%');
            });


            if($request->has('itemsPerPage')) {

                $itemsPerPage = $request->get('itemsPerPage');

                return $task->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($request->has('itemsPerPage'))
        {
            $itemsPerPage = $request->get('itemsPerPage');
        }

        return $task->paginate($itemsPerPage);
    }

    /**
     * Retrieve all tasks.
     *
     * @return JsonResponse
     */
    public function getAllTasks()
    {
        // Implement the logic to retrieve all tasks
        return Task::orderBy('id', 'desc')->get();
    }

    /**
     * Create a new task.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // Implement the logic to create a new task
        DB::beginTransaction();

        try {
            $task = new Task();

            $task->title = $request->title;
            $task->body = $request->body;
            $task->status = $request->status ?? false;
            $task->created_by = Auth::id() ?? 1;

            $task->save();

            DB::commit();

            return $task;

        } catch (HttpException $e) {

            DB::rollBack();

            return $e;
        } catch (Throwable $th) {

            DB::rollBack();

            return $th;
        }
    }

    /**
     * Retrieve a specific task by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        // Implement the logic to retrieve a specific task by ID
        $task = Task::find($id);

        if (!$task) {
            throw new HttpException(404, 'Task not found');
        }

        return $task;
    }

    /**
     * Update a specific task by ID.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        // Implement the logic to update a specific task by ID
        DB::beginTransaction();

        try {
            $task = Task::find($id);

            if (!$task) {
                throw new HttpException(404, 'Task not found');
            }

            $task->title = $request->title ?? $task->title;
            $task->body = $request->body ?? $task->body;
            $task->status = $request->status ?? false;
            $task->is_completed = $request->is_completed ?? false;
            $task->created_by = Auth::id();

            $task->save();

            DB::commit();

            return $task;

        } catch (HttpException $e) {

            DB::rollBack();

            return $e;

        } catch (Throwable $th) {

            DB::rollBack();

            return $th;
        }
    }

    /**
     * Delete a specific task by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        // Implement the logic to delete a specific task by ID
        DB::beginTransaction();
        try {
            $task = Task::find($id);

            if (!$task) {
                throw new HttpException(404, 'Task not found');
            }

            $task->delete();

            DB::commit();

            return true;

        } catch (HttpException $e) {

            DB::rollBack();

            return false;

        } catch (Throwable $th) {

            DB::rollBack();

            return false;
        }
    }

    /**
     * Change the status of a specific task by ID.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function changeStatus(Request $request, int $id)
    {
        // Implement the logic to change the status of a specific task by ID
        DB::beginTransaction();

        try {
            $task = Task::find($id);

            if (!$task) {
                throw new HttpException(404, 'Task not found');
            }

            $task->status = $request->status;
            $task->save();

            DB::commit();

            return $task;

        } catch (HttpException $e) {

            DB::rollBack();

            return $e;

        } catch (Throwable $th) {

            DB::rollBack();

            return $th;
        }
    }

    /**
     * Change the completion status of a specific task by ID.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */  
    public function changeCompleteStatus(Request $request, int $id)
    {
        // Implement the logic to change the completion status of a specific task by ID
        DB::beginTransaction();

        try {
            $task = Task::find($id);

            if (!$task) {
                throw new HttpException(404, 'Task not found');
            }

            $task->is_completed = $request->is_completed;
            $task->save();

            DB::commit();

            return $task;

        } catch (HttpException $e) {

            DB::rollBack();

            return $e;

        } catch (Throwable $th) {

            DB::rollBack();

            return $th;
        }
    }
}