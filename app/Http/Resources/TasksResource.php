<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => (string)$this->id,
            "attributes" => [
                "title" => $this->title,
                "description" => $this->description,
                "status" => $this->status,
                "assignee_id" => $this->assignee_id,
                "dependency_of" => $this->dependency_of,
                "due_date_from" => $this->due_date_from,
                "due_date_to" => $this->due_date_to
            ],

            "relationships" => [
                "id" => (string)$this->user->id,
                "user name" => $this->user->name,
                "user email" => $this->user->email
            ]
        ];
    }
}
