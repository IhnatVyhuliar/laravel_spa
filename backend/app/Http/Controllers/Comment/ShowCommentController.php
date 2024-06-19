<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Requests\SubmitEmailRequest;
use App\Rules\StringValidationRule;

class ShowCommentController extends Controller
{
    public function index(): object
    {
       return app(CommentService::class)->getDefaultComments(false);        
    }

    public function sortByEmail(SubmitEmailRequest $request): object
    {   
        return app(CommentService::class)->sortByEmail($request->email);
    }

    public function sortByName(Request $request): object
    {   
        $request->validate([
            'name' => ['required', 'string', new StringValidationRule],
        ]);
       return app(CommentService::class)->sortByName($request->name);
    }

    public function sortByDate(): object
    {   
        return app(CommentService::class)->getDefaultComments(true);  
    }


}
