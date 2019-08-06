<div class="row">
    <div class="col-md-8">
        <div class="form-group has-feedback">
            <label for="title" class="text-muted">Título</label>
            <input id="title" type="text" name="title" class="form-control" value="{{ $post->title ?? null }}">
        </div>
        <div class="form-group has-feedback">
            <label for="body" class="text-muted">Postagem</label>
            <textarea id="body" name="body" rows="10" class="form-control">{{ $post->body ?? null }}</textarea>
        </div>
        <div class="form-group has-feedback">
            <label for="tags" class="text-muted">Tags</label>
            <select id="tags" type="text" name="tags[]" multiple class="form-control">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ !empty($post) && $post->has_tag($tag->id) ? 'selected' : null }}>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="image" class="text-muted">Imagem de capa<sup>(Recomendado: 1200x400)</sup></label>
            <div class="custom-image border-radius-min">
                @php
                    $id = $post->id ?? null;
                    $file = $post->image ?? null;
                    $file_folder = "posts/{$id}";
                @endphp
                <img id="image-post" class="image border-radius-min" alt="Imagem" title="Imagem" src="{{ CustomFile::get($file, $file_folder, ['tim' => ['w' => 1200, 'h' => 400]]) }}" default="">
                <div class="input-items-group">
                    <input type="file" name="image" id="slide-cover" class="inputfile preview-image">
                    <label for="slide-cover"><i class="fas fa-camera"></i></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="author" class="text-muted">Author</label>
            <select id="author" name="author" class="form-control">
                <option value="">Selecione um author</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == ($post->user_id ?? null) ? 'selected' : null }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status" class="text-muted">Situação</label>
            <select id="status" name="status" class="form-control">
                <option value="">Selecione uma situação</option>
                <option value="1" {{ empty($post) || ($post->status ?? null) == 1 ? 'selected' : null }}>Publicado</option>
                <option value="0" {{ !empty($post) && $post->status != 1 ? 'selected' : null }}>Rascunho</option>
            </select>
        </div>
    </div>
</div>
