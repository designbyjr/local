<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeysOnlyResource;
use App\Http\Resources\KeysResource;
use App\Models\Key;
use App\Models\Language;
use App\Services\ExportService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class KeysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return Response::json(["keys" => KeysOnlyResource::collection(Key::all()) ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            "key_name" => "required|unique:keys,name",
            "text" => "required",
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return response()->json(["errors"=>$validator->messages()], 400);
        }

        if ($request->user()->cannot('create', Key::class)) {
           return Response::make('User Is Not Authorised',401);
        }
        $key = Key::create([
            "name" => $request->json('key_name'),
            "input" => $request->json('text'),
        ]);

        return Response::json(["key" => KeysResource::make($key) ],201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Key $key)
    {
        return Response::json(["key" => KeysResource::make($key) ])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $key
     *
     */
    public function update(Request $request, Key $key)
    {
        $data = $request->all();
        $rules = [
            "key_name" => "required|unique:keys,name",
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return response()->json(["errors"=>$validator->messages()], 400);
        }

        if ($request->user()->cannot('update', $key)) {
            return Response::make('User Is Not Authorised',401);
        }

        $key->update([
            "name" => $request->json('key_name'),
        ]);

        return Response::json(["key" => KeysResource::make($key->refresh()) ],202)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $key
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function updateTranslation(Request $request, Key $key)
    {
        $data = $request->all();
        $rules = [
            "text" => "required",
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            return response()->json(["errors"=>$validator->messages()], 400);
        }

        if ($request->user()->cannot('update', $key)) {
            return Response::make('User Is Not Authorised',401);
        }

        $key->update([
            "input" => $request->json('text'),
        ]);

        return Response::json(["key" => KeysResource::make($key->refresh()) ],202)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $key
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request, Key $key)
    {
        if ($request->user()->cannot('delete', $key)) {
            return Response::make('User Is Not Authorised',401);
        }
        $key->delete();
        return Response::json(["key" => "Deleted" ],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function export(Request $request)
    {
        if ($request->user()->cannot('create', Key::class)) {
            return Response::make('User Is Not Authorised',401);
        }

        $zipFile = new \PhpZip\ZipFile();
        $files = [];
        foreach (Language::all() as $language)
        {
            $jsonFile = (new ExportService())->toJsonFile($language);
            $zipFile->addFile($jsonFile,$language->name.'-iso.json');
            $files[] = $jsonFile;
        }

        $yamlFile = (new ExportService())->toYamlFile();
        $zipFile->addFile($yamlFile,"translations.yaml");
        $zipFile->saveAsFile(base_path("translations.zip"));
        $zipFile->close();
        // clean up temporary files.
        unlink($yamlFile);
        foreach ($files as $file)
        {
            unlink($file);
        }
        header('Content-type: application/zip');
        header('Content-Disposition: inline; filename="translations.zip"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        return Response::download(base_path("translations.zip"));

    }
}
