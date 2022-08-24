<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Language\DataTables\LanguageDataTable;
use Modules\Language\Entities\Language;
use Modules\Language\Http\Requests\StoreLanguageRequest;
use Modules\Language\Http\Requests\UpdateLanguageRequest;
use Modules\Language\Languages;
use Nwidart\Modules\Facades\Module;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:languages-create')->only('create', 'store');
        $this->middleware('permission:languages-read')->only('index');
        $this->middleware('permission:languages-update')->only('edit', 'update');
        $this->middleware('permission:languages-delete')->only('edit', 'destroy');
    }

    public function index(LanguageDataTable $dataTable)
    {
        return $dataTable->render('language::index');
    }

    public function create()
    {
        $languages = Languages::getList();
        return view('language::create', compact('languages'));
    }

    public function store(StoreLanguageRequest $request)
    {

        $code = $request->input('language');
        $language = Languages::get($code);

        \DB::beginTransaction();
        try {
            Language::create([
                'name' => $language['name'],
                'native_name' => $language['nativeName'],
                'code' => $code
            ]);

            $this->generatePhrases($code);

            \DB::commit();

            return response()->json([
                'message' => __("Language Created Successfully"),
                'redirect' => route('admin.languages.index')
            ]);
        }catch (\Throwable $e){
            \DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function edit(Language $language)
    {
        $path = lang_path($language->code.'.json');
        if (!file_exists($path)){
            $this->generatePhrases($language->code);
        }

        $phrases = file_get_contents($path);
        $phrases = json_decode($phrases, true);

        return view('language::edit', compact('phrases', 'language'));
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        file_put_contents(lang_path($language->code.'.json'), json_encode($request->validated()['phrases']));

        return response()->json([
            'message' => __("Phrases Updated Successfully"),
            'redirect' => route('admin.languages.edit', $language->id)
        ]);
    }

    public function destroy(Language $language)
    {
        if ($language->isSystem || $language->isDeafult){
            return response()->json([
                'message' => __('You are not allowed to delete system language')
            ], 403);
        }

        if ($language->isDeafult){
            return response()->json([
                'message' => __('You are not allowed to delete default language')
            ], 403);
        }

        if (file_exists(lang_path($language->code).'.json')){
            \File::delete(lang_path($language->code).'.json');
        }
        $language->delete();

        return response()->json([
            'message' => __('Language Deleted Successfully'),
        ]);
    }

    private function generatePhrases($code){
        $phrases = [];

        // Get Laravel Lang
        if (file_exists(base_path('lang/en.json'))){
            $phrase = file_get_contents(base_path('lang/en.json'));
            $phrase = json_decode($phrase, true);
            foreach (collect($phrase) as $index => $item) {
                $phrases[$index] = $item;
            }
        }

        // Get Module Lang
        foreach (Module::allEnabled() as $module){
            $path = base_path('Modules/'.$module.'/Resources/lang/en.json');
            if (file_exists($path)){
                $phrase = file_get_contents($path);
                $phrase = json_decode($phrase, true);
                foreach (collect($phrase) as $index => $item) {
                    $phrases[$index] = $item;
                }
            }
        }

        file_put_contents(base_path('lang/'.$code.'.json'), json_encode($phrases));
    }

    public function sync(Language $language)
    {
        // TODO:: implement this section

        return response()->json([
            'message' => __('Phrases Translated Successfully'),
            'redirect' => route('admin.languages.edit', $language->id)
        ]);
    }
}
