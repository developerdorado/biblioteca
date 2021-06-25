<div class="modal fade" id="editarLibro" tabindex="-1" aria-labelledby="editarLibroLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarLibroLabel">Editar libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit_libro" name="edit_libro" method="POST">
          <div class="mb-3">
            <label for="idlib" class="col-form-label">IDLIB</label>
            <input type="number" class="form-control" id="idlib" name="idlib" placeholder="Ingrese un identificador único" readonly autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="nombre_libro" class="col-form-label">Nombre del libro</label>
            <input type="text" class="form-control" id="nombre_libro" name="nombre_libro" placeholder="Nombre del libro" required autocomplete="off">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="editar_libro" >Editar</button>
      </div>
      </form>
    </div>
  </div>
</div>