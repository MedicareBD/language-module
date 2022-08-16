<div class="btn-group btn-group-sm">
    @can('languages-update')
        <a href="{{ route('admin.languages.edit', $model->id) }}" class="btn btn-success">
            <i class="fas fa-edit"></i>
        </a>
    @endcan
    @if(!$model->isSystem)
        @can('languages-delete')
            <a href="{{ route('admin.languages.destroy', $model->id) }}" class="btn btn-danger confirm-delete">
                <i class="fas fa-trash"></i>
            </a>
        @endcan
    @endif
</div>
