<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinuxCreateRequest;
use App\Http\Requests\LinuxUpdateRequest;
use App\Http\Resources\LinuxDetailResource;
use App\Http\Resources\LinuxListResource;
use App\Models\Linux;
use Illuminate\Http\Resources\Json\JsonResource;
use YajTech\Crud\Controllers\CrudController;

class LinuxController extends CrudController
{
    public function __construct()
    {
        parent::__construct(
            Linux::class,
            LinuxDetailResource::class,
            LinuxListResource::class,
            LinuxCreateRequest::class,
            LinuxUpdateRequest::class
        );
    }

    public function showOld(): JsonResource
    {
        $linuxCollection = Linux::orderBy('created_at', 'asc')->get();

        return LinuxDetailResource::collection($linuxCollection);
    }

    public function deleteCascade($id)
    {
        // Get the ID from the request
        // $id = $request->id;

        // Find the record by its ID
        $record = Linux::find($id);

        if ($record) {
            // Call a recursive function to delete the record and its children
            $this->deleteRecordWithChildren($record);

            return response()->json(['message' => 'Record and its children deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Record not found'], 404);
        }
    }

    private function deleteRecordWithChildren($record)
    {
        // Find all children of the record
        $children = Linux::where('parent_id', $record->id)->get();

        // Recursively delete all children
        foreach ($children as $child) {
            $this->deleteRecordWithChildren($child);
        }

        // Delete the current record
        $record->delete();
    }
}
