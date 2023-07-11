<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TemplateController extends Controller
{
    // get all the templates
    public function getImageTemplates()
    {
        // path to public
        $path = public_path('id_template/');
       
        // get all images in path
        $imageFiles = File::files($path);
        // dd($imageFiles);
        $imageNames = [];
        foreach ($imageFiles as $imageFile) {
            $imageNames[] = basename($imageFile);
        }
        return response()->json($imageNames);
    }

    // save template
    public function saveImageTemplates(Request $request){
        $alreadySaveT = Template::where('template_name',$request->templates['template'])->first();
        // dd($request);
        if($alreadySaveT){
            $alreadySaveT->template_name = $request->templates['template'];
            // canvas
            $alreadySaveT->canvas_width = $request->canvas['width'];
            $alreadySaveT->canvas_height = $request->canvas['height'];
            // profile
            $alreadySaveT->profile_x = $request->profile['x'];
            $alreadySaveT->profile_y = $request->profile['y'];
            // contents st_no
            $alreadySaveT->textContents_0_x = $request->textContents[0]['x'];
            $alreadySaveT->textContents_0_y = $request->textContents[0]['y'];
            // contents course
            $alreadySaveT->textContents_1_x = $request->textContents[1]['x'];
            $alreadySaveT->textContents_1_y = $request->textContents[1]['y'];
            // contents lastname
            $alreadySaveT->textContents_2_x = $request->textContents[2]['x'];
            $alreadySaveT->textContents_2_y = $request->textContents[2]['y'];
            // contents fisrtname
            $alreadySaveT->textContents_3_x = $request->textContents[3]['x'];
            $alreadySaveT->textContents_3_y = $request->textContents[3]['y'];
            // contents middlename
            $alreadySaveT->textContents_4_x = $request->textContents[4]['x'];
            $alreadySaveT->textContents_4_y = $request->textContents[4]['y'];
            $alreadySaveT->save();
            return response()->json(['message' => 'Template Updated successfully']);
        }else{
            $template = new Template();
            $template->template_name = $request->templates['template'];
            // canvas
            $template->canvas_width = $request->canvas['width'];
            $template->canvas_height = $request->canvas['height'];
            // profile
            $template->profile_x = $request->profile['x'];
            $template->profile_y = $request->profile['y'];
            // contents st_no
            $template->textContents_0_x = $request->textContents[0]['x'];
            $template->textContents_0_y = $request->textContents[0]['y'];
            // contents course
            $template->textContents_1_x = $request->textContents[1]['x'];
            $template->textContents_1_y = $request->textContents[1]['y'];
            // contents lastname
            $template->textContents_2_x = $request->textContents[2]['x'];
            $template->textContents_2_y = $request->textContents[2]['y'];
            // contents fisrtname
            $template->textContents_3_x = $request->textContents[3]['x'];
            $template->textContents_3_y = $request->textContents[3]['y'];
            // contents middlename
            $template->textContents_4_x = $request->textContents[4]['x'];
            $template->textContents_4_y = $request->textContents[4]['y'];
            $template->save();
            return response()->json(['message' => 'Template saved successfully']);
        }
    }

    // get the template coordinates
    public function getTemplateCoordinates(){
        // just for now
        $tmpCoordinates = Template::get();
        return response()->json($tmpCoordinates);
    }
}
