<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        if (Request::routeIs('admin.store.task')) {
            $rules = [
                'title'        => 'required|string|max:255|unique:tasks,title',
                'body'         => 'nullable|string',
                'status'       => 'sometimes|boolean',
            ];
        }

        if (Request::routeIs('admin.update.task')) {
            $rules = [
                'title'        => 'required|string|max:255',
                'body'         => 'nullable|string',
                'is_completed' => 'nullable|boolean',
                'status'       => 'sometimes|boolean',
            ];
        }

        if (Request::routeIs('admin.changeStatus.task')) {
            $rules = [
                'status' => 'required|boolean',
            ];
        }

        if (Request::routeIs('admin.changeCompleteStatus.task')) {
            $rules = [
                'is_completed' => 'required|boolean',
            ];
        }

        return $rules;
    }
}