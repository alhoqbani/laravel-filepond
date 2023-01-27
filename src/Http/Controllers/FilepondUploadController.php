<?php

namespace Alhoqbani\Filepond\Http\Controllers;

use Alhoqbani\Filepond\Models\FilepondMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class FilepondUploadController
{
    /**
     * Handle upload requests from Filepond.js
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process(Request $request): string
    {
        $files = $request->allFiles();

        if (count($files) !== 1) {
            throw ValidationException::withMessages([
                'filepond' => 'Number of files should be one, we got ' . count($files),
            ]);
        }

        /** @var FilepondMedia $filepondFile */
        $filepondFile = FilepondMedia::createFromRequestFile(Arr::first($files));

        return $filepondFile->uuid;
    }

    /**
     * Handle revert (delete) requests from Filepond.js
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function revert(Request $request): \Illuminate\Http\JsonResponse
    {
        $filepondMedia = FilepondMedia::findByUuid($request->getContent());

        if (!$filepondMedia instanceof FilepondMedia) {
            abort(404);
        }

        try {
            if ($filepondMedia->delete()) {
                return response()->json();
            }

            return response()->json(['message' => 'Something went wrong.'], 400);

        } catch (\Exception $exception) {

            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
