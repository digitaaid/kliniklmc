<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collIcare">
        <h3 class="card-title ">
            i-Care JKN
        </h3>
        <div class="card-tools">
            @if ($urlicare)
                Terhubung <i class="fas fa-check-circle"></i>
            @else
                Tidak Terhubung <i class="fas fa-info-circle"></i>
            @endif
        </div>
    </a>
    <div id="collIcare" class="collapse" role="tabpanel" aria-labelledby="headIcare">
        <div class="card-body">
            @if ($urlicare)
                <iframe src="{{ $urlicare }}" width="100%" height="500px" frameborder="0"></iframe>
                {{ $messageicare }}
            @else
                Mohon Maaf ! {{ $messageicare }}
            @endif
        </div>
    </div>
</div>
