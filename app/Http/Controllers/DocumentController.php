<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        $specialist = $request->user()->specialist;
        
        $files=$request->file('files');
        if($specialist!==null && $files!== null)
        {
            
            $error = false;
            foreach($files as $file)
            {
                $document = new Document();
                $document->disc='protected';
                $pathOrFalse=Storage::disk('protected')->putFile('documents',$file);
                if(!$pathOrFalse)
                {
                    $error=true;
                    continue;
                }

                $document->path=$pathOrFalse;
                $document->extension=Storage::disk('protected')->mimeType($pathOrFalse);
                $document->name = $file->getClientOriginalName();
                $specialist->documents()->save($document);
            }

            return $error ?
            redirect()->back()->with('message', ['text' => 'Dodano tylko część plików.', 'status' => 'error']) :
            redirect()->back()->with('message', ['text' => 'Dodano pliki.', 'status' => 'success']);
        }
        return  redirect()->back()->with('message', ['text' => 'Nie masz uprawnień, aby wykonać tę akcję.', 'status' => 'error']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document) : RedirectResponse
    {
        if(Auth::user()->specialist->documents()->find($document->id)!==null)
        {
           if(Storage::disk('protected')->delete($document->path))
           {
            $document->delete();
            return redirect()->back()->with('message', ['text' => 'Usunięto plik.', 'status' => 'success']);
           }else{
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
           }

        }
    }

    public function download(Document $document) : StreamedResponse|Response
    {
        if(Auth::user()?->specialist?->documents()?->find($document->id) || Auth::user()->myRole->name==='admin'){
            return Storage::disk('protected')->download($document->path);
        }else{
            return response('Nie masz uprawnień, aby pobrać plik.',401);
        }
        
    }
}
