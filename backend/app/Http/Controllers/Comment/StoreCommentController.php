<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\ReplyComment;
use App\Http\Requests\StoreCommentRequest;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use App\Services\TagClosedService;
use App\Models\SavedComment;
use Illuminate\Support\Facades\Storage;

class StoreCommentController extends Controller
{
    public function store(StoreCommentRequest $request): object
    {

        $photo_file = null;
        if($request->has('photo_file')){
            $photo_file=$request->file('photo_file')->store('public/comments/photo');
        }
        $txt_file = null;
        if($request->has('txt_file')){
            $fileContent = file_get_contents(storage_path($request->file('txt_file')));

            if ($this->checkTags($fileContent))
            {
                if (app(TagClosedService::class)->checkString()){
                    $txt_file = $request->file('txt_file')->store('public/comments/txt');
                }
                else{
                    abort(403);
                }
            }
            
            
        }
        
        $comment = Comment::create([
            'comment_text'=>$request->comment_text,
            'home_page'=>$request->home_page,
            'txt_file'=> $txt_file,
            'user_id'=>$request->user()->id,
            'photo_file'=>$photo_file
        ]);

        if ($request->has('reply_id')){
            $comment = Comment::findOrFail($request->reply_id);
            if ($comment){
                ReplyComment::create([
                    'user_id' => $request->user()->id,
                    'comment_id' => $request->reply_id,
                    'comment_reply_id' => $comment->id
                ]);
            }
        }
        return $comment;
    }

    public function addToSaved(Comment $comment, Request $request)
    {   
        $saved = SavedComment::create([
            'user_id' => $request->user()->id,
            'comment_id' => $comment->id
        ]);

        return $saved;
    }

    public function deleteMessage(Comment $comment, Request $request)
    {
        if($comment->user_id === $request->user()->id){
            Storage::delete($comment->photo_file);
            Storage::delete($comment->txt_file);

            $comment->delete();
        }
    }

    private function  checkTags(string $string): bool 
    {
        // Remove allowed tags from the string
        $allowedTags = ['<a>', '<i>', '<code>', '<strong>'];
        $filteredString = strip_tags($string, implode('', $allowedTags));
    
        // Compare the filtered string with the original
        return $filteredString !== $string;
    }
}
