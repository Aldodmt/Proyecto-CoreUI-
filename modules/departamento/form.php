<?php
if ($_GET['form'] == 'add') { ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title">Agregar Departamento</i>
    </h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="?module=departamento">Departamentos</a></li>
        <li class="breadcrumb-item"><a>Agregar</a></li>
      </ol>
    </nav>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form role="form" class="form-horizontal" action="modules/departamento/proses.php?act=insert" method="POST">
              <div class="form-group">
                <?php
                //metodo para generar codigo
                $query_id = mysqli_query($mysqli, "SELECT MAX(id_departamento) as id FROM departamento")
                  or die('Error' . mysqli_error($mysqli));
                $count = mysqli_num_rows($query_id);
                if ($count <> 0) {
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigo = $data_id['id'] + 1;
                } else {
                  $codigo = 1;
                }
                ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Codigo</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Descripcion</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="dep_descripcion" pleaceholder="Ingresa un departamento"
                      required>
                  </div>
                </div>
                <br>

                <div class="box-footer">
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                      <a href="?module=departamento" class="btn btn-default btn-reset">Cancelar</a>
                    </div>
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php } elseif ($_GET['form'] == 'edit') {
  if (isset($_GET['id'])) {
    $query = mysqli_query($mysqli, "SELECT *FROM departamento WHERE id_departamento = '$_GET[id]'")
      or die('Error' . mysqli_error($mysqli));
    $data = mysqli_fetch_assoc($query);
  } ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title">Modificar Departamento</i>
    </h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="?module=departamento">Departamentos</a></li>
        <li class="breadcrumb-item"><a>Modificar</a></li>
      </ol>
    </nav>
  </section>


  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <form role="form" class="form-horizontal" action="modules/departamento/proses.php?act=update" method="POST">
            <div class="box-body">
              <?php
              //metodo para generar codigo
            
              ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigo" value="<?php echo $data['id_departamento']; ?>"
                    readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Descripcion</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="dep_descripcion"
                    value="<?php echo $data['dep_descripcion']; ?>" required>
                </div>
              </div>
              <br>

              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary btn-submit" name="Guardar" value="Guardar">
                    <a href="?module=departamento" class="btn btn-default btn-reset">Cancelar</a>
                  </div>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

<?php }
?>