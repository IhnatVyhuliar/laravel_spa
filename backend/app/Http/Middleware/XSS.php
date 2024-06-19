<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $userInput = $request->comment_text;
       // echo json_encode($request->all());
        $allowedTags = '<a><code><i><strong>';
        $allowedTags = ['<a>', '<i>', '<code>', '<strong>'];
        $filteredString = strip_tags($userInput, implode('', $allowedTags));
    
        // Compare the filtered string with the original
        if ($filteredString !== $userInput){
            abort(403, "Tags not valid");
        }
        $cleanedContent = strip_tags($userInput, $allowedTags);

        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $cleanedContent, $result);
        preg_match_all('#</([a-z]+)>#iU', $cleanedContent, $result2);
        // echo count($result2);
        // $openedtags = $result[1];
        if (count($result[0]) != count($result2[0])){
            abort(403, "Tags not valid");
        }
        for($i = 0; $i< count($result[0]); $i++){
            switch ($result[0][$i]) {
                case "<a>":
                    if ($result2[0][$i] != "</a>"){
                        abort(403, "Tags not valid");
                    }
                    break;

                case '<code>':
                    if ($result2[0][$i] != "</code>"){
                        abort(403, "Tags not valid");
                    }
                    break;
                case '<strong>':
                    if ($result2[0][$i] != "</strong>"){
                        abort(403, "Tags not valid");
                    }
                    break;

            }
        }

        // echo json_encode($cleanedContent);
        $request->merge(['comment_text' => $cleanedContent]);
        return $next($request);
    }
}
