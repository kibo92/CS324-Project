<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Blog;
use App\Comment;
use Validator;
use DB;
use DateTime;

class BlogController extends Controller
{
    public function create(Request $request){
		$input_json = $request->getContent();
		$input = json_decode($input_json,true);
		$rules = ['text' => 'required|min:100','title'=> 'required|min:20'];
		$validator = Validator::make($input,$rules);
		if (!$validator->fails())
		{
			$user = UserController::getUserByToken($request);
			$text = $input['text'];
			$title = $input['title'];
			$response = Blog::create([
			  'text' => $text,
			  'title' => $title,
			  'user_id' => $user->id,
			  'created_at' => new DateTime()
			]);
			return response()->json($response,201);
		}else{
			$messages = $validator->messages();
			return response()->json(['error' => $messages],400);
		}
	}
	
	public function allBlogs(){
		$questions = Blog::select()->orderBy('created_at', 'desc')->get();
		return response()->json($questions);
	}
	
	
	 public function createComment(Request $request){
		$input_json = $request->getContent();
		$input = json_decode($input_json,true);
		$rules = ['text' => 'required|min:20','blog_id'=>'required|Integer|exists:blogs,id'];
		$validator = Validator::make($input,$rules);
		if (!$validator->fails())
		{
			$user = UserController::getUserByToken($request);
			$text = $input['text'];
			$blog_id = $input['blog_id'];
			$response = Comment::create([
			  'text' => $text,
			  'blog_id'=>$blog_id,
			  'user_id' => $user->id,
			  'created_at' => new DateTime()
			]);
			return response()->json($response,201);
		}else{
			$messages = $validator->messages();
			return response()->json(['error' => $messages],400);
		}
	}
	
	public function allCommentsForBlog($blog_id){
		$result = Comment::select()
		->where('comments.blog_id',"=",$blog_id)
		->get();
		return response()->json($result);
	}

	public function deleteById($blog_id, Request $request){
		$user = UserController::getUserByToken($request);
		$blog = DB::table('blogs')->where('id',$blog_id)->first();
		if(isset($blog) && $blog->user_id == $user->id){
			DB::table('blogs')->where('id', $blog_id)->delete();
			return response()->json(['success'=>"Success deletion"],200);
		}else{
			return response()->json(['error'=>'Answer does not belong to user'],400);
		}
	}


	
}

