<div class="modal fade" id="nuevoLibro" tabindex="-1" aria-labelledby="nuevoLibroLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro nuevo libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="registro_libro" name="registro_libro" method="POST">
          <div class="mb-3">
            <label for="idlib" class="col-form-label">IDLIB</label>
            <input type="number" class="form-control" name="idlib" placeholder="Ingrese un identificador único" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="nombre_libro" class="col-form-label">Nombre del libro</label>
            <input type="text" class="form-control" name="nombre_libro" placeholder="Nombre del libro" required autocomplete="off">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="guardar_libro" >Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>