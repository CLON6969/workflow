<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home;


class WebHomepageContentController extends Controller
{
    public function edit()
    {
        $content = Home::first();

        if (!$content) {
            $content = Home::create([
                'title1' => '',
                'title2' => '',
            ]);
        }

        return view('admin.web.homepage.content.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([

            // Titles
            'title1' => 'required|string|max:255',
            'title1_content' => 'nullable|string',
            'title1_sub_content' => 'nullable|string',

            'title2' => 'required|string|max:255',
            'title2_content' => 'nullable|string',

            'title3' => 'nullable|string|max:255',
            'title3_content' => 'nullable|string',
            'title3_sub_content' => 'nullable|string',

            'title4' => 'nullable|string|max:255',
            'title4_content' => 'nullable|string',
            'title4_sub_content' => 'nullable|string',

            // Images
            'background_picture' => 'nullable|image',
            'picture1' => 'nullable|image',
            'background_picture2' => 'nullable|image',

            // Buttons (NO url strict validation)
            'button1_name' => 'nullable|string|max:255',
            'button1_url' => 'nullable|string|max:255',

            'button2_name' => 'nullable|string|max:255',
            'button2_url' => 'nullable|string|max:255',

            'button3_name' => 'nullable|string|max:255',
            'button3_url' => 'nullable|string|max:255',

            'button4_name' => 'nullable|string|max:255',
            'button4_url' => 'nullable|string|max:255',
        ]);

        $content = Home::first();

        if (!$content) {
            $content = new Home();
        }

        // Titles
        $content->title1 = $request->title1;
        $content->title1_content = $request->title1_content;
        $content->title1_sub_content = $request->title1_sub_content;

        $content->title2 = $request->title2;
        $content->title2_content = $request->title2_content;

        $content->title3 = $request->title3;
        $content->title3_content = $request->title3_content;
        $content->title3_sub_content = $request->title3_sub_content;

        $content->title4 = $request->title4;
        $content->title4_content = $request->title4_content;
        $content->title4_sub_content = $request->title4_sub_content;

        // Buttons
        $content->button1_name = $request->button1_name;
        $content->button1_url = $request->button1_url;

        $content->button2_name = $request->button2_name;
        $content->button2_url = $request->button2_url;

        $content->button3_name = $request->button3_name;
        $content->button3_url = $request->button3_url;

        $content->button4_name = $request->button4_name;
        $content->button4_url = $request->button4_url;

        // Images
        if ($request->hasFile('background_picture')) {
            $filename = $request->file('background_picture')
                ->store('uploads/pics', 'public');
            $content->background_picture = basename($filename);
        }

        if ($request->hasFile('picture1')) {
            $filename = $request->file('picture1')
                ->store('uploads/pics', 'public');
            $content->picture1 = basename($filename);
        }

        if ($request->hasFile('background_picture2')) {
            $filename = $request->file('background_picture2')
                ->store('uploads/pics', 'public');
            $content->background_picture2 = basename($filename);
        }

        $content->save();

        return redirect()
            ->route('admin.web.homepage.content.edit')
            ->with('success', 'Homepage content updated successfully.');
    }
}