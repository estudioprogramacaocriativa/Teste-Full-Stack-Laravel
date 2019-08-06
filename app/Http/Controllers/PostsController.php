<?php

namespace App\Http\Controllers;

use App\Helpers\FileManager;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use App\TagPost;
use App\User;

class PostsController extends Controller
{
    /**
     * Return a list of posts resources
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::orderBy('title')->paginate(10);

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
            $posts = Post::where('status', $this->getStatus($status))->orderBy('title')->paginate(10);
        endif;

        return response()->json(['data' => $this->getTableBody($posts, $status)]);
    }

    /**
     * Search a post resource
     *
     * @param null $word
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($word = null)
    {
        sleep(1);
        $posts = Post::orderBy('title')->paginate(10);

        if(!empty($word)):
            $posts = Post::where('title', 'LIKE', '%' . $word . '%')->orderBy('title')->paginate(10);
        endif;

        return response()->json(['data' => $this->getTableBody($posts, null, $word)]);
    }

    /**
     * Show the form to create a new post resource
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('users', 'tags'));
    }

    /**
     * Store a new post resource
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $tags = $request->input('tags');
        $image = $request->file('image');
        $store = Post::create($request->except('image'));
        $this->createTags($store->id, $tags);

        FileManager::upload(Post::class, $image, "posts/{$store->id}", $store->id, 'image');

        return response()->json([
            'clean_form' => true,
            'message' => "O post <b>{$store->title}</b> foi inserido!",
            'reset_img' => [
                'target' => 'image-post',
                'path' => asset('images/no-image.jpg')
            ]
        ]);
    }

    /**
     * Show form for edit post resource
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $users = User::orderBy('name')->get();
        $post = Post::find($id);
        $tags = Tag::orderBy('name')->get();

        return view('posts.edit', compact('post', 'users', 'tags'));
    }

    /**
     * Update a post resource
     *
     * @param PostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $tags = $request->input('tags');
        $image = $request->file('image');
        $post->update($request->except('image'));
        $this->createTags($post->id, $tags, true);

        FileManager::upload(Post::class, $image, "posts/{$post->id}", $post->id, 'image', ['current' => $post->image]);

        return response()->json(['message' => "O post <b>{$post->title}</b> foi atualizado!"]);
    }

    /**
     * Delete a post resource
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        sleep(1);
        $post = Post::find($id);
        $title = $post->title;

        try {
            FileManager::destroy("posts/{$post->id}", $post->image);
            $post->delete();
            $posts = Post::orderBy('title')->paginate(10);

            return response()->json([
                'message' => "O post <b>{$title}</b> foi removido!",
                'data' => $this->getTableBody($posts)
            ]);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Não é possível remover o registro porque ele está em uso no momento.',], 403);
        }
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

    /**
     * Store tags relation between tags and post
     *
     * @param $post_id
     * @param $tags
     * @param bool $delete
     */
    private function createTags($post_id, $tags, $delete = false)
    {
        if($delete || empty($tags)):
            TagPost::where('post_id', '=', $post_id)->delete();
        endif;

        if(!empty($tags)):
            foreach ($tags as $tag):
                TagPost::create(['tag_id' => $tag, 'post_id' => $post_id]);
            endforeach;
        endif;
    }
}
