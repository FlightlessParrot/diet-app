<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = Storage::disk('protected')->files('documents');
        Storage::disk('protected')->delete($files);
        $specialists = Specialist::all();
        if(!Storage::disk('public')->exists('test/test.pdf'))
        {
            throw new \Exception('There is no test.pdf file. Unable to create documents.');
        }
        foreach($specialists as $specialist)
        {
            $document = new Document();
            $file=new File('storage/app/public/test/test.pdf');
            $pathOrFalse=Storage::disk('protected')->putFile('documents',$file);
            if(!$pathOrFalse){
                throw new \Exception('Document seeder cannot save a document.');
            }
            $document->disc='protected';
            $document->path=$pathOrFalse;
            $document->extension=Storage::disk('protected')->mimeType($pathOrFalse);
            $document->name = 'Test document';
            $specialist->documents()->save($document);
        }
    }
}
