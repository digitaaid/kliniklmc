<div class="card card-info mb-1">
    <div class="card-header" role="tab" id="headIcare">
        <h3 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collIcare"
                aria-expanded="true" aria-controls="collIcare">
                i-Care JKN
            </a>
        </h3>
    </div>
    <div id="collIcare" class="collapse" role="tabpanel" aria-labelledby="headIcare">
        <div class="card-body">
            @if ($urlicare)
                <iframe src="{{ $urlicare }}" width="100%" height="500px"
                    frameborder="0"></iframe>
                {{ $messageicare }}
            @else
                Mohon Maaf ! {{ $messageicare }}
            @endif
        </div>
    </div>
</div>
