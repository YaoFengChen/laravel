<?php

namespace App\Http\Controllers;

use App\Model\Files;
use App\Services\FileService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * @OA\post(
     *     path="/file",
     *     summary="儲存檔案",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(ref="#components/schemas/item"),
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             description="the file what you want to upload",
     *                             property="file",
     *                             type="string", format="binary"
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="檔案上傳成功"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     *
     * @param Request $request
     * @return JsonResponse | void
     */
    public function saveFile(Request $request)
    {
        $fileName = Storage::put('a1', $request->file('file'));

        if (!is_string($fileName)) {
            return response()->json([], 500);
        }

        Files::create(['name' => $fileName]);
    }

    /**
     * @OA\get(
     *     path="/file",
     *     summary="取得檔案列表",
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="成功取得檔案列表"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     *
     * @return JsonResponse
     */
    public function getFiles()
    {
        return response()->json(Files::get('id'));
    }

    /**
     * @OA\get(
     *     path="/file/{id}",
     *     summary="下載檔案",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="file id",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="成功取得檔案列表"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     *
     * @param $id
     * @param FileService $fileService
     * @return string
     * @throws BindingResolutionException
     */
    public function downloadFile($id, FileService $fileService)
    {
        $file = $fileService->getFile($id);

        if (is_null($file)) {
            return response()->json([], 404);
        }

        return response()->make(
            Storage::temporaryUrl(
                $file->name,
                now()->addMinutes(5)
            ),
            200,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename=' . $file->name,
            ]
        );
    }

    /**
     *
     * @OA\delete(
     *     path="/file/{id}",
     *     summary="移除檔案",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="file id",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="token",
     *     in="query",
     *     description="jwt token",
     *     required=true,
     *     ),
     *     @OA\Response(response="200", description="成功移除檔案"),
     *     @OA\Response(response="500", description="未預期錯誤")
     * )
     * @param $id
     * @param FileService $fileService
     * @return JsonResponse | void
     */
    public function deleteFile($id, FileService $fileService)
    {
        $file = $fileService->getFile($id);

        if (is_null($file)) {
            return response()->json([], 404);
        }

        if (!Storage::delete($file->name)) {
            return response()->json([], 500);
        }

        Files::destroy($id);
    }
}
