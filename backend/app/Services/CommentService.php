<?php 

    namespace App\Services;
    use App\Models\Comment;
    use App\Models\ReplyComment;
    use Illuminate\Database\Eloquent\Builder;

    class CommentService
    {
        public function __construct(
            protected int $limit
        ){}

        public function getComments(bool $reverse=false): Builder
        {
            $sortparam = "DESC";
            if ($reverse){
                $sortparam = "ASC";
            }
            $data = Comment::leftJoin('reply_comments', 'reply_comments.comment_reply_id', '=', 'comments.id')
                    ->leftJoin('users', 'users.id', '=', 'comments.user_id')
                    ->whereNull('comment_reply_id')
                    ->select('comments.*')
                    ->limit($this->limit)
                    ->orderBy("comments.created_at", $sortparam)
                    ->with('replyComments.comment:id,home_page,comment_text,txt_file,photo_file,user_id,created_at')
                    ->with('user:id,name,email');
                    

            
            return $data;
        }
    
        public function sortByEmail(string $email)
        {
            return $this->getComments()->where('users.email', "=", $email)->get();
        }

        public function sortByName(string $name)
        {
            return $this->getComments()->where('users.name', "=", $name)->get();
        }

        public function getDefaultComments($reverse = false)
        {
            return $this->getComments($reverse)->get();
        }


    }