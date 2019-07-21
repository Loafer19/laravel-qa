@if ($model instanceof App\Question)
    @php
        $name = 'question';
    @endphp
@else
    @php
        $name = 'answer';
    @endphp
@endif

    <div class="d-flex flex-column vote-controls">
        <a href="" title="This {{ $name }} is useful"
            class="vote-up {{ Auth::guest() ? 'off' : '' }}"
            onclick="event.preventDefault(); document.getElementById('up-vote-{{ $name }}-{{ $model->id }}').submit();">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <form action="/{{ $name }}s/{{ $model->id }}/vote" method="post" id="up-vote-{{ $name }}-{{ $model->id }}" style="display:none">
            @csrf
            <input type="hidden" name="vote" value="1">
        </form>

        <span class="votes-count">{{ $model->votes_count }}</span>

        <a href="" title="This {{ $name }} is not useful"
            class="vote-down {{ Auth::guest() ? 'off' : '' }}"
            onclick="event.preventDefault(); document.getElementById('down-vote-{{ $name }}-{{ $model->id }}').submit();">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
        <form action="/{{ $name }}s/{{ $model->id }}/vote" method="post" id="down-vote-{{ $name }}-{{ $model->id }}" style="display:none">
            @csrf
            <input type="hidden" name="vote" value="-1">
        </form>

        @if ($model instanceof App\Question)
            <a href="" title="Click to mark as favorite question (Click again to undo)" class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
                onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit();">
                <i class="fas fa-star fa-2x"></i>
                <span class="favorites-count">{{ $model->favorites_count }}</span>
            </a>
            <form action="/questions/{{ $model->id }}/favorites" method="post" id="favorite-question-{{ $model->id }}" style="display:none">
                @csrf
                @if ($model->is_favorited)
                    @method('DELETE')
                @endif
            </form>

        @else
            {{-- Answers --}}
            @can ('accept', $model)
                <a href="" title="Mark this answer as best answer"
                    class="{{ $model->status }} mt-2"
                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();"
                    >
                    <i class="fas fa-check fa-2x"></i>
                </a>
                <form action="{{ route('answers.accept', $model->id) }}" method="post" id="accept-answer-{{ $model->id }}" style="display:none">
                    @csrf
                </form>
            @else
                @if ($model->is_best)
                    <a href="" title="The question owner accepted this answer as the best answer"
                        class="{{ $model->status }} mt-2">
                        <i class="fas fa-check fa-2x"></i>
                    </a>
                @endif
            @endcan
        @endif
    </div>
