<div class="container-fluid bg-dark-grey p-5 mb-5">
    <div class="row">
        <div class="col-12 text-center">
            <a class="btn btn-outline-light btn-lg p-5" href="note@create">
                + New Note
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?=$notes ?? 'Could not load notes'?>
    </div>
</div>