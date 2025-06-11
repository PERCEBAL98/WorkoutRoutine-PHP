<nav class="navbar fixed-top header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn" id="menuBtn"><img src="<?= baseUrl() ?>/assets/icons/menu-cerrar.svg" alt="menu"></button>
            <a class="navbar-brand ms-2" href="<?= baseUrl() ?>/"><img src="<?= baseUrl() ?>/assets/img/logo.png" alt="logo" class="logo-img">WorkoutRoutine</a>
        </div>
        <div id="contenedorIntermedio">
            <div class="container-fluid d-flex align-items-center contenedor-buscador">
            <?php if (isset($showFormEjercicios) && $showFormEjercicios) { ?>
                <form class="d-flex justify-content-center mx-auto" id="formEjercicios">
                    <input class="form-control" type="search" id="searchInput" placeholder="Buscar ejercicios">
                    <button class="btn" id="searchBtn" type="submit"><img src="<?= baseUrl() ?>/assets/icons/lupa.svg" alt="lupa"></button>
                </form>
                <button class="btn ms-1" id="filterBtn" data-bs-toggle="modal" data-bs-target="#filterModal"><span class="filter-text me-1">Filtros</span><img src="<?= baseUrl() ?>/assets/icons/filtro.svg" alt="filtro"></button>
            <?php } ?>
            <?php if (isset($showFormRutinas) && $showFormRutinas) { ?>
                <form class="d-flex justify-content-center mx-auto" id="formRutinas">
                    <input class="form-control" type="search" id="searchInputRutinas" placeholder="Buscar rutinas">
                    <button class="btn" id="searchBtnRutinas" type="submit"><img src="<?= baseUrl() ?>/assets/icons/lupa.svg" alt="lupa"></button>
                </form>
                <button class="btn ms-1" id="filterBtnRutinas" data-bs-toggle="modal" data-bs-target="#filterRutinasModal"><span class="filter-text me-1">Filtros</span><img src="<?= baseUrl() ?>/assets/icons/filtro.svg" alt="filtro"></button>
            <?php } ?>
            </div>
        </div>
        <div class="d-flex align-items-center">
        <?php if (isset($showFormEjercicios) && $showFormEjercicios) { ?>
            <button class="btn" id="searchBtnExpanded" type="submit"><img src="<?= baseUrl() ?>/assets/icons/lupa.svg" alt="lupa"></button>
        <?php } ?>
        <?php if (isset($showFormRutinas) && $showFormRutinas) { ?>
            <button class="btn" id="searchBtnRutinasExpanded" type="submit"><img src="<?= baseUrl() ?>/assets/icons/lupa.svg" alt="lupa"></button>
        <?php } ?>
        <?php if (session()->get('usuario')) { ?>
            <div class="dropdown me-1">
                <a href="#" class="btn dropdown-toggle me-1" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div id="numeroNotificaciones" class="<?php if(!empty($this->notificaciones)):?> show <?php endif; ?>"><?= count($this->notificaciones ?? []) ?></div>
                    <img src="<?= baseUrl() ?>/assets/icons/campana.svg" alt="campana">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" id="notificationDropdownMenu" aria-labelledby="notificationDropdown">
                    <li>
                        <div class="cabecera-notificaciones d-flex justify-content-between align-items-center ms-3 me-1">
                            <span>Notificaciones</span>
                            <a class="btn ms-1" href="#"><img src="<?= baseUrl() ?>/assets/icons/dropdown-ajustes.svg" alt="engranaje"></a>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <div class="contenido_notificaciones">
                        <li class="p-2">
                            <div class="container-sin-notificaciones <?php if(empty($this->notificaciones)):?> show <?php endif; ?>">
                                <img src="<?= baseUrl() ?>/assets/icons/campana-tachada.svg" alt="campana tachada" style="height: 36px;">
                                <span>Estás al día, no hay nuevas notificaciones.</span>
                            </div>
                        </li>
                        <?php
                            if (!empty($this->notificaciones)) {
                                foreach ($this->notificaciones as $notificacion) {
                        ?>
                        <li>
                            <a href="#" class="dropdown-item container-notificacion">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="titulo"><?= ($notificacion['titulo']) ?></span>
                                    <button class="btn ms-1 me-1" data-id="<?= $notificacion['id'] ?>"><img src="<?= baseUrl() ?>/assets/icons/dropdown-papelera.svg" alt="papelera"></button>
                                </div>
                                <div class="d-flex me-1">
                                    <img src="<?= baseUrl() ?>/assets/img/<?= $notificacion['imagen'] ?>" class="descripcion-img me-1"></img>
                                    <span class="descripcion"><?= ($notificacion['mensaje']) ?></span>
                                </div>
                            </a>
                        </li>
                        <?php
                                } 
                            }
                        ?>
                    </div>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="navbar-brand dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= baseUrl() ?>/assets/img/<?= session()->get('avatar') ?>" alt="Perfil" class="profile-img border">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="<?= baseUrl() ?>/perfil"><img src="<?= baseUrl() ?>/assets/icons/dropdown-usuario.svg" alt="perfil" class="me-1">Mi Perfil</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= baseUrl() ?>/calendario"><img src="<?= baseUrl() ?>/assets/icons/dropdown-calendario.svg" alt="calendario" class="me-1">Calendario</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= baseUrl() ?>/ajustes"><img src="<?= baseUrl() ?>/assets/icons/dropdown-ajustes.svg" alt="engranaje" class="me-1">Ajustes</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                    <a class="dropdown-item" href="<?= baseUrl() ?>/salir"><img src="<?= baseUrl() ?>/assets/icons/dropdown-salir.svg" alt="salir" class="me-1">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        <?php } else { ?>
            <a href="<?= baseUrl() ?>/sigin" class="dropdown-toggle">
                <p class="ms-1 me-1">Iniciar sesión</p>
                <img src="<?= baseUrl() ?>/assets/img/user-image-default.webp" alt="Perfil" class="profile-img">
            </a>
        <?php } ?>
        </div>
    </div>
</nav>
<?php if (isset($showFormEjercicios) && $showFormEjercicios) { ?>
<nav class="navbar contenedor-buscador-expanded fixed-top">
    <div class="container-contenedor-buscador-expanded d-flex justify-content-between align-items-center">
        <button class="btn me-1" id="backBtn" type="submit"><img src="<?= baseUrl() ?>/assets/icons/flecha-izquierda-2.svg" alt="flecha"></button>
    </div>
</nav>

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filtros Ejercicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row col-filtro">
                    <div class="col col-sm-4 col-6">
                        <span>Movimiento</span>
                        <hr>
                        <div class="row">
                            <a data-campo="movimiento" data-valor="tirar" class="col-12">Tirar</a>
                            <a data-campo="movimiento" data-valor="empujar" class="col-12">Empujar</a>
                            <a data-campo="movimiento" data-valor="estático" class="col-12">Estático</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Nivel</span>
                        <hr>
                        <div class="row">
                            <a data-campo="nivel" data-valor="principiante" class="col-12">Principiante</a>
                            <a data-campo="nivel" data-valor="intermedio" class="col-12">Intermedio</a>
                            <a data-campo="nivel" data-valor="experto" class="col-12">Experto</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Mecánica</span>
                        <hr>
                        <div class="row">
                            <a data-campo="mecanica" data-valor="aislado" class="col-12">Aislado</a>
                            <a data-campo="mecanica" data-valor="compuesto" class="col-12" >Compuesto</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Categoria</span>
                        <hr>
                        <div class="row">
                            <a data-campo="categoria" data-valor="pliométricos" class="col-12">Pliométricos</a>
                            <a data-campo="categoria" data-valor="fuerza" class="col-12">Fuerza</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Músculo primario</span>
                        <hr>
                        <div class="row">
                            <a data-campo="musculo_primario" data-valor="hombros" class="col-12">Hombros</a>
                            <a data-campo="musculo_primario" data-valor="tríceps" class="col-12">Tríceps</a>
                            <a data-campo="musculo_primario" data-valor="bíceps" class="col-12">Bíceps</a>
                            <a data-campo="musculo_primario" data-valor="antebrazo" class="col-12">Antebrazos</a>
                            <a data-campo="musculo_primario" data-valor="pecho" class="col-12">Pecho</a>
                            <a data-campo="musculo_primario" data-valor="dorsales" class="col-12">Dorsales</a>
                            <a data-campo="musculo_primario" data-valor="abdominales" class="col-12">Abdominales</a>
                            <a data-campo="musculo_primario" data-valor="espalda" class="col-12">Espalda</a>
                            <a data-campo="musculo_primario" data-valor="glúteos" class="col-12">Glúteos</a>
                            <a data-campo="musculo_primario" data-valor="abductores" class="col-12">Abductores</a>
                            <a data-campo="musculo_primario" data-valor="aductores" class="col-12">Aductores</a>
                            <a data-campo="musculo_primario" data-valor="isquiotibiales" class="col-12">Isquiotibiales</a>
                            <a data-campo="musculo_primario" data-valor="cuádriceps" class="col-12">Cuádriceps</a>
                            <a data-campo="musculo_primario" data-valor="gemelos" class="col-12">Gemelos</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Músculo secundario</span>
                        <hr>
                        <div class="row">
                            <a data-campo="musculo_secundario" data-valor="hombros" class="col-12">Hombros</a>
                            <a data-campo="musculo_secundario" data-valor="tríceps" class="col-12">Tríceps</a>
                            <a data-campo="musculo_secundario" data-valor="bíceps" class="col-12">Bíceps</a>
                            <a data-campo="musculo_secundario" data-valor="antebrazo" class="col-12">Antebrazos</a>
                            <a data-campo="musculo_secundario" data-valor="pecho" class="col-12">Pecho</a>
                            <a data-campo="musculo_secundario" data-valor="dorsales" class="col-12">Dorsales</a>
                            <a data-campo="musculo_secundario" data-valor="abdominales" class="col-12">Abdominales</a>
                            <a data-campo="musculo_secundario" data-valor="espalda" class="col-12">Espalda</a>
                            <a data-campo="musculo_secundario" data-valor="glúteos" class="col-12">Glúteos</a>
                            <a data-campo="musculo_secundario" data-valor="abductores" class="col-12">Abductores</a>
                            <a data-campo="musculo_secundario" data-valor="aductores" class="col-12">Aductores</a>
                            <a data-campo="musculo_secundario" data-valor="isquiotibiales" class="col-12">Isquiotibiales</a>
                            <a data-campo="musculo_secundario" data-valor="cuádriceps" class="col-12">Cuádriceps</a>
                            <a data-campo="musculo_secundario" data-valor="gemelos" class="col-12">Gemelos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="borrarFiltros">Borrar Filtros</button>
                <button type="button" class="btn" id="aplicarFiltros">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($showFormRutinas) && $showFormRutinas) { ?>
<nav class="navbar contenedor-buscador-rutinas-expanded fixed-top">
    <div class="container-contenedor-buscador-rutinas-expanded d-flex justify-content-between align-items-center">
        <button class="btn me-1" id="backBtnRutinas" type="submit"><img src="<?= baseUrl() ?>/assets/icons/flecha-izquierda-2.svg" alt="flecha"></button>
    </div>
</nav>

<div class="modal fade" id="filterRutinasModal" tabindex="-1" aria-labelledby="filterRutinasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterRutinasModalLabel">Filtros Rutinas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row col-filtro">
                    <div class="col col-sm-4 col-6">
                        <span>Nivel</span>
                        <hr>
                        <div class="row">
                            <a data-campo="nivel" data-valor="principiante" class="col-12">Principiante</a>
                            <a data-campo="nivel" data-valor="intermedio" class="col-12">Intermedio</a>
                            <a data-campo="nivel" data-valor="experto" class="col-12">Experto</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Fecha de creación</span>
                        <hr>
                        <div class="row">
                            <a data-campo="fecha" data-valor="dia" class="col-12">Hoy</a>
                            <a data-campo="fecha" data-valor="semana" class="col-12">Esta semana</a>
                            <a data-campo="fecha" data-valor="mes" class="col-12">Este mes</a>
                        </div>
                    </div>
                    <div class="col col-sm-4 col-6">
                        <span>Favoritos</span>
                        <hr>
                        <div class="row">
                            <a data-campo="favorito" data-valor="1" class="col-12">Si</a>
                            <a data-campo="favorito" data-valor="0" class="col-12">No</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="borrarFiltros">Borrar Filtros</button>
                <button type="button" class="btn" id="aplicarFiltros">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($showFormEjercicios) && $showFormEjercicios || isset($showFormRutinas) && $showFormRutinas) { ?>
<nav class="navbar contenedor-filtros fixed-top expanded" id="contenedorFiltros">
    <div id="filtrosSeleccionados"></div>
</nav>
<?php } ?>
