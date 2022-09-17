<div>
    <div class="modal fade" id="imagenQR" style="z-index: 99999" aria-labelledby="imagenQRLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center col-11" id="imagenQRLabel">QR</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img class="h-100 w-100" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(json_encode(['id' =>  $pedido,'estado' => '3'  ]))); !!}" alt="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
