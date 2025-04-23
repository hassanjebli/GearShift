<select id="modelSelect" name="model_id">
    <option value="" style="display: block">Modèle</option>
    @foreach($models as $model)
        <option value="{{ $model->id }}" data-parent="{{ $model->maker_id }}"
            @selected($attributes->get('value') == $model->id)>
            {{ $model->name }}
        </option>
    @endforeach
</select>
