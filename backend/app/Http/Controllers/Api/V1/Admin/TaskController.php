<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\TaskRequest;
use App\Http\Services\Api\V1\Admin\Task\TaskInterface;
use App\Http\Services\Api\V1\Admin\Task\TaskService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskInterface $taskService) 
    {
        
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', "true");

        if ($pagination === "true") {

            $banner = $this->taskService->index($request);

            return GlobalResponse::success($banner, "All task fetch successful with pagination", \Illuminate\Http\Response::HTTP_OK);

        }

        if ($request->get('pagination') === "false")
        {
            $banner = $this->taskService->getAllTasks();

            return GlobalResponse::success($banner, "All task fetch successful", \Illuminate\Http\Response::HTTP_OK);
        }
    }

    public function store(TaskRequest $request)
    {
        try{

            $task = $this->taskService->store($request);

            return GlobalResponse::success($task, "Store successful", Response::HTTP_CREATED);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Store failed", $e->getStatusCode());

        } catch (ValidationException $e) {

            return GlobalResponse::error($e->validator->errors(), "Validation failed", Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {

            $task = $this->taskService->show($id);

            return GlobalResponse::success($task, "Task fetch successful", Response::HTTP_OK);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Task fetch failed", $e->getStatusCode());

        } catch (ModelNotFoundException $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(TaskRequest $request, $id)
    {
        try {

            $task = $this->taskService->update($request, $id);

            return GlobalResponse::success($task, "Task update successful", Response::HTTP_OK);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Task update failed", $e->getStatusCode());

        } catch(ValidationException $e) {

            return GlobalResponse::error($e->validator->errors(), "Validation failed", Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (ModelNotFoundException $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

    public function destroy($id)
    {
        try {

            $this->taskService->destroy($id);

            return GlobalResponse::success("", "Task delete successful", Response::HTTP_OK);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Task delete failed", $e->getStatusCode());

        } catch (ModelNotFoundException $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function changeStatus(TaskRequest $request, $id)
    {
        try {

            $task = $this->taskService->changeStatus($request, $id);

            return GlobalResponse::success($task, "Task status change successful", Response::HTTP_OK);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Task status change failed", $e->getStatusCode());

        } catch (ModelNotFoundException $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function changeCompleteStatus(TaskRequest $request, $id)
    {
        try {

            $task = $this->taskService->changeCompleteStatus($request, $id);

            return GlobalResponse::success($task, "Task complete status change successful", Response::HTTP_OK);

        } catch (HttpException $e) {

            return GlobalResponse::error($e->getMessage(), "Task complete status change failed", $e->getStatusCode());

        } catch (ModelNotFoundException $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return GlobalResponse::error("", $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Handle the destruction of the TaskController instance.
     *
     * This method is called when the object is destroyed.
     */
    public function __destruct()
    {
        unset($this->taskService);
    }
}