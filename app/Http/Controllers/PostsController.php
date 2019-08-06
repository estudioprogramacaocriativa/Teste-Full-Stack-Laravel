<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Return a list of posts resources
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Return a list of posts resources
     * filtered by status column
     *
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function filtered($status)
    {
        sleep(1);
        $posts = Post::paginate(10);

        if($status !== 'all'):
            $posts = Post::where('status', $this->getStatus($status))->paginate(10);
        endif;

        return response()->json(['data' => $this->getTableBody($posts, $status)]);
    }

    public function search($word = null)
    {
        sleep(1);
        $posts = Post::paginate(10);

        if(!empty($word)):
            $posts = Post::where('title', 'LIKE', '%' . $word . '%')->paginate(10);
        endif;

        return response()->json(['data' => $this->getTableBody($posts, null, $word)]);
    }

    public function criar()
    {
        return view('posts.create');
    }

    public function salvar(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        \App\Post::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $post = \App\Post::where('title', $request->title)->get();

        foreach ($request->tags as $tag) {
            \DB::table('tag_post')->insert([
                'tag_id' => $tag->id,
                'post_id' => $post[0]->id
            ]);
        }

        return redirect('posts');
    }

    public function editar($id)
    {
        $post = \App\Post::find($id);

        return view('posts.edit', ['post' => $post]);
    }

    public function atualizar(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = \App\Post::find($id);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        \DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        foreach ($request->tags as $tag_id) {
            \DB::table('tag_post')->insert([
                'tag_id' => $tag_id,
                'post_id' => $post->id
            ]);
        }

        return redirect('posts');
    }

    public function deletar($id)
    {
        $post = \App\Post::find($id);

        $post->delete();

        \DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        return redirect('posts');
    }

    /**
     * Get the HTML list of post resources
     *
     * @param $posts
     * @param null $status
     * @param null $word
     * @return string
     */
    private function getTableBody($posts, $status = null, $word = null)
    {
        $view = \View::make('posts.partials.table-body', compact('posts', 'status', 'word'));
        $render = (string)$view->render();

        return $render;
    }

    /**
     * Get the post status
     *
     * @param $status
     * @return int
     */
    private function getStatus($status)
    {
        switch($status):
            case 'published':
                $value = 1;
                break;
            case 'draft':
            default:
                $value = 0;
                break;
        endswitch;

        return $value;
    }
}
