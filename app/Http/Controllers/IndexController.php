<?php

namespace App\Http\Controllers;

use App\Http\Requests\Index\SubmitRequest;
use App\Mail\ContactUs;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function search(Request $request, PostServiceInterface $postService)
    {
        if ($request->q) {
            $posts = $postService->getSearchPagination($request, 20);
            return view('posts.search', ['posts' => $posts]);
        }

        return redirect()
            ->route('main');
    }

    public function submit(SubmitRequest $request)
    {
        Mail::send(new ContactUs($request->validated()));

        return back()
            ->with('status', 'Your message has been sent');
    }

    public function contact()
    {
        return view('contact');
    }

    public function privacy()
    {
        return view('policy.privacy');
    }

    public function terms()
    {
        return view('policy.terms');
    }

    public function cookies()
    {
        return view('policy.cookies');
    }
}
