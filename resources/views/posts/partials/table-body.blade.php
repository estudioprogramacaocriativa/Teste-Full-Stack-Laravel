    @if($posts->count() > 0)
        @foreach($posts as $post)
            <tr>
                <td>
                    <a class="link" href="{{ route('post.edit', $post->id) }}">
                        {{ strlen($post->title) > 50 ? substr_replace($post->title, '...', 50) : $post->title }}
                    </a>
                </td>
                <td></td>
                <td></td>
                <td class="btn-actions">
                    <a class="btn btn-outline-info mr-3" href="{{ url('posts/edit/' . $post->id) }}"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-outline-danger" href="{{ url('posts/destroy/' . $post->id) }}"><i class="fas fa-trash"></i></a>
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
            @elseif(!empty($search))
                <p>Não encontramos publicações para a palavra chave <b>{{ $search }}</b>.</p>
            @else
                <p>Não existem publicações até o momento!</p>
            @endif
        </td>
    </tr>
    @endif
