<?php ?>

<div class="box box-success">
    <div class="box-header with-border">
        <!-- Barra de progreso -->
        <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            </div>
        </div>
    </div>


    <div class="accordion" style="padding: 5px;">
        <div class="accordion-section">

            <button><a style="margin-bottom: 4px" class="accordion-section-title" href="#accordion-1"><img>Mis Solicitudes</a></button>
            <div id="accordion-1" class="accordion-section-content">
                <div class="search">
                    <input type="text" id="txt_buscar_vendedores" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                    <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                </div><br><br>
                <div class="row">
                    <br><br>
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                            <table id="tbl_vendedores">
                                <thead style="width: 100%">
                                    <tr>
                                        <th><label>Nombre</label></th>
                                        <th><label>Apellido</label></th>
                                        <th><label>Cédula</label></th>
                                        <th><label>Rol</label></th>
                                        <th><label>Correo</label></th>
                                        <th><label>Teléfono</label></th>
                                        <th><label>Celular</label></th>
                                        <th><label>Valor cuenta</label></th>
                                        <th><label>Editar</label></th>
                                    </tr>
                                </thead>
                                <tbody>



                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div><!--end .accordion-section-content-->

            <button><a style="margin-bottom: 4px" class="accordion-section-title" href="#accordion-2">Solicitudes Distribuidor</a></button>
            <div id="accordion-2" class="accordion-section-content">
                <div class="search">
                    <input type="text" id="txt_buscar_clientes" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                    <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                </div><br><br><br>
                <div class="row">
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

                            <table id="tbl_clientes">
                                <thead style="width: 100%">
                                    <tr>
                                        <th><label>Nombre</label></th>
                                        <th><label>Apellido</label></th>
                                        <th><label>Cédula</label></th>
                                        <th><label>Correo</label></th>
                                        <th><label>Dirección</label></th>
                                        <th><label>Teléfono</label></th>
                                        <th><label>Celular</label></th>
                                        <th><label>Valor cuenta</label></th>
                                    </tr>
                                </thead>
                                <tbody>




                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div><!--end .accordion-section-content-->

            <button><a class="accordion-section-title" href="#accordion-3">Solicitudes Cliente</a></button>
            <div id="accordion-3" class="accordion-section-content">
                <div class="search">
                    <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                    <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                </div><br><br>
                <div class="row">
                    <br><br>
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                            <table>
                                <thead style="width: 100%">
                                    <tr>
                                        <th><label>Fecha Solicitud</label></th>
                                        <th><label>Saldo Solicitado</label></th>
                                        <th><label>Responsable</label></th>
                                        <th><label>Estado</label></th>

                                    </tr>
                                </thead>
                                <tbody>




                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div><!--end .accordion-section-content-->




            <button><a class="accordion-section-title" href="#accordion-4">Solicitudes Saldo Vendedor</a></button>
            <div id="accordion-4" class="accordion-section-content">
                <div class="search">
                    <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                    <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                </div><br><br>
                <div class="row">
                    <br><br>
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                            <table>
                                <thead style="width: 100%">
                                    <tr>
                                        <th><label>Fecha Solicitud</label></th>
                                        <th><label>Saldo Solicitado</label></th>
                                        <th><label>Vendedor</label></th>
                                        <th><label>Estado</label></th>

                                    </tr>
                                </thead>
                                <tbody>



                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div><!--end .accordion-section-content-->




        </div><!--end .accordion-section-->


    </div><!--end .accordion-->

</div>

