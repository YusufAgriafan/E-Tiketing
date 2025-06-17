<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $labelledBy }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $labelledBy }}">{{ $title }}</h5>
                <button type="button" class="close" onclick="$('#{{ $id }}').modal('hide');" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
