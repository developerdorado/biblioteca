<div class="modal fade" id="editarPrestamo" tabindex="-1" aria-labelledby="nuevoPrestamoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar prestamo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editar_prestamo" name="editar_prestamo" method="POST">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="idlib" class="col-form-label">IDLIB</label>
                                <input type="number" class="form-control" name="idlib" id="edit_idlib" placeholder="IDLIB" readonly required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_libro" class="col-form-label">NOMBRE LIBRO</label>
                                <input type="text" class="form-control" name="nombre_libro" id="edit_nombre_libro" placeholder="NOMBRE LIBRO" readonly required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="estado" class="col-form-label">ESTADO</label>
                                <select class="form-control" name="estado_prestamo" id="estado_prestamo">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="identificacion" class="col-form-label">IDENTIFICACIÓN</label>
                                <input type="number" class="form-control" name="identificacion" id="identificacion" placeholder="No. identificación" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre" class="col-form-label">NOMBRE</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="apellido" class="col-form-label">APELLIDO</label>
                                <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" required autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_nacimiento" class="col-form-label">FECHA NACIMIENTO</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="telefono" class="col-form-label">NÚMERO CELULAR</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="No. celular" required autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_limite" class="col-form-label">FECHA LIMITE</label>
                                <input type="date" class="form-control" name="fecha_limite" id="fecha_limite" required autocomplete="off">
                            </div>
                        </div>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="edit_prestamo">Actualizar</button>
            </div>
            </form>
        </div>
    </div>
</div>