    @if($posts->count() > 0)
        @foreach($posts as $post)
            <tr>
                <td>
                    <a class="link" href="{{ route('post.edit', $post->id) }}">
                        {{ strlen($post->title) > 50 ? substr_replace($post->title, '...', 50) : $post->title }}
                    </a>
                </td>
                <td><i style="font-size: .876em; color: #848484;">{{ $post->author->name ?? 'Indefinido' }}</i></td>
                <td>
                    <p class="status {{ Functions::getStatus($post->status, [0 => 'draft', 1 => 'published']) }}">
                        {{ Functions::getStatus($post->status, [0 => 'Rascunho', 1 => 'Publicado']) }}
                    </p>
                </td>
                <td class="btn-actions">
                    <a class="btn btn-outline-info mr-3" href="{{ url('posts/edit/' . $post->id) }}"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-outline-danger j-trash" data-id="{{ $post->id }}" data-controller="App\Http\Controllers\PostsController" data-route="{{ route('post.destroy', $post->id) }}" href="{{ url('posts/destroy/' . $post->id) }}"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4">
                {{ $posts->links() }}
            </td>
        </tr>
    @else
    <tr class="empty-results">
        <td colspan="4">
            <p class="icon"><i class="far fa-frown-open"></i></p>
            @if(!empty($status))
                <p>Não encontramos publicações marcadas como <b>{{ Functions::getStatus($status, ['draft' => 'rascunho', 'published' => 'publicados']) }}</b>.</p>
            @elseif(!empty($word))
                <p>Não encontramos publicações para a palavra chave <b>{{ $word }}</b>.</p>
            @else
                <p>Não existem publicações até o momento!</p>
            @endif
        </td>
    </tr>
    @endif
