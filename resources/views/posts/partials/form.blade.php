<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title" class="text-muted">Título</label>
                    <input id="title" type="text" name="title" class="form-control">
                    @if ($errors->has('title'))
                        <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="author" class="text-muted">Author</label>
                    <select id="author" name="author" class="form-control">
                        <option value="">Selecione um author</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group has-feedback{{ $errors->has('body') ? ' has-error' : '' }}">
            <label for="body" class="text-muted">Postagem</label>
            <textarea id="body" name="body" rows="10" class="form-control"></textarea>
            @if ($errors->has('body'))
                <span class="help-block">
            <strong>{{ $errors->first('body') }}</strong>
        </span>
            @endif
        </div>
        <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="tags" class="text-muted">Tags</label>
            <select id="tags" type="text" name="tags[]" multiple class="form-control">
                @foreach(\App\Tag::all() as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('tags'))
                <span class="help-block">
            <strong>{{ $errors->first('tags') }}</strong>
        </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="image" class="text-muted">Imagem de capa</label>
            <div class="custom-image border-radius-min">
                <img class="image border-radius-min" alt="Imagem" title="Imagem" src="{{ asset('images/no-image.jpg') }}" default="">
                <div class="input-items-group">
                    <input type="file" name="image" id="slide-cover" class="inputfile preview-image">
                    <label for="slide-cover"><i class="fas fa-camera"></i></label>
                </div>
            </div>
        </div>
    </div>
</div>