<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'SiginController::index');
$routes->get('/sigin', 'SiginController::login', ['filter'=>'noAuthGuard']);
$routes->match(['get', 'post'], '/sigin/loginAuth', 'SiginController::loginAuth');
$routes->get('/sigin/register', 'SiginController::register', ['filter'=>'noAuthGuard']);
$routes->match(['get', 'post'], '/sigin/registerUser', 'SiginController::registerUser');
$routes->get('/salir','SiginController::logout');

$routes->get('/terminos-condiciones','DeportistasController::terminosCondiciones');
$routes->get('/privacidad','DeportistasController::privacidad');
$routes->get('/cookies','DeportistasController::cookies');
$routes->get('/aviso-legal','DeportistasController::avisoLegal');
$routes->get('/preguntas','DeportistasController::preguntas');

//--------------------------------------------------------------------------
// USUARIOS
//--------------------------------------------------------------------------
$routes->get('/perfil','DeportistasController::index', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/perfil/avatar','DeportistasController::cambiarAvatar', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/perfil/cambiar-password','DeportistasController::cambiarPassword', ['filter'=>'authGuard']);
$routes->get('/calendario', 'DeportistasController::calendario', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/calendario/detalle', 'DeportistasController::detalleCalendario', ['filter' => 'authGuard']);
$routes->get('/ajustes','DeportistasController::ajustes');
$routes->get('/usuarios/listado','DeportistasController::dashboard', ['filter'=>'authGuardIsAdmin']);
$routes->get('/usuarios/nuevo','DeportistasController::nuevo', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/usuarios/crear','DeportistasController::crear', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/usuarios/editar','DeportistasController::editar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/usuarios/actualizar','DeportistasController::actualizar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/usuarios/eliminar','DeportistasController::eliminar', ['filter'=>'authGuardIsAdmin']);

//--------------------------------------------------------------------------
// ROLES
//--------------------------------------------------------------------------
$routes->get('/roles/listado','RolesController::dashboard', ['filter'=>'authGuardIsAdmin']);
$routes->get('/roles/nuevo','RolesController::nuevo', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/roles/crear','RolesController::crear', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/roles/editar','RolesController::editar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/roles/actualizar','RolesController::actualizar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/roles/eliminar','RolesController::eliminar', ['filter'=>'authGuardIsAdmin']);

//--------------------------------------------------------------------------
// EJERCICIOS
//--------------------------------------------------------------------------
$routes->get('/ejercicios', 'EjerciciosController::index');
$routes->get('/ejercicios/pagina/(:num)', 'EjerciciosController::cargarEjercicios/$1');
$routes->get('/ejercicios/filtrados/pagina/(:num)', 'EjerciciosController::cargarEjerciciosConFiltros/$1');
$routes->get('/ejercicios/ejercicio/(:segment)', 'EjerciciosController::obtenerEjercicioPorId/$1');
$routes->get('/ejercicios/listado','EjerciciosController::dashboard', ['filter'=>'authGuardIsAdmin']);
$routes->get('/ejercicios/nuevo','EjerciciosController::nuevo', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/ejercicios/crear','EjerciciosController::crear', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/ejercicios/editar','EjerciciosController::editar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/ejercicios/actualizar','EjerciciosController::actualizar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/ejercicios/eliminar','EjerciciosController::eliminar', ['filter'=>'authGuardIsAdmin']);

//--------------------------------------------------------------------------
// LOGROS
//--------------------------------------------------------------------------
$routes->get('/logros', 'LogrosController::index', ['filter'=>'authGuard']);
$routes->get('/obtenerLogros', 'LogrosController::obtenerLogros', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/logros/rutinas', 'LogrosController::actualizarLogrosRutinasRealizadas', ['filter'=>'authGuard']);
$routes->get('/logros/listado','LogrosController::dashboard', ['filter'=>'authGuardIsAdmin']);
$routes->get('/logros/nuevo','LogrosController::nuevo', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/logros/crear','LogrosController::crear', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/logros/editar','LogrosController::editar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/logros/actualizar','LogrosController::actualizar', ['filter'=>'authGuardIsAdmin']);
$routes->match(['get', 'post'], '/logros/eliminar','LogrosController::eliminar', ['filter'=>'authGuardIsAdmin']);

//--------------------------------------------------------------------------
// RUTINAS
//--------------------------------------------------------------------------
$routes->get('/rutinas', 'RutinasController::index', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/rutinas/favorito', 'RutinasController::añadirFavorito', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/rutinas/eliminar', 'RutinasController::eliminar', ['filter'=>'authGuard']);
$routes->get('/rutinas/pagina/(:num)', 'RutinasController::cargarRutinas/$1', ['filter'=>'authGuard']);
$routes->get('/rutinas/filtrados/pagina/(:num)', 'RutinasController::cargarRutinasConFiltros/$1', ['filter'=>'authGuard']);
$routes->get('/rutina', 'RutinasController::verRutina', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/rutina/guardar', 'RutinasController::guardarRutina', ['filter'=>'authGuard']);
$routes->get('/rutina/(:segment)', 'RutinasController::obtenerRutinaPorId/$1', ['filter'=>'authGuard']);
$routes->get('/realizar/rutina', 'RutinasController::realizarRutina', ['filter'=>'authGuard']);
$routes->match(['get', 'post'],'/rutinas/automaticamente/crear', 'RutinasController::crearAutomaticamente', ['filter'=>'authGuard']);
$routes->get('/rutinas/automaticamente', 'RutinasController::automaticamente', ['filter'=>'authGuard']);
$routes->match(['get', 'post'],'/rutinas/personalizada/crear', 'RutinasController::crearPersonalizada', ['filter'=>'authGuard']);
$routes->get('/rutinas/personalizada', 'RutinasController::personalizada', ['filter'=>'authGuard']);
$routes->get('/calendario/cargar', 'RutinasController::cargarRutinasCalendario', ['filter'=>'authGuard']);
$routes->match(['get', 'post'], '/rutina/completar', 'RutinasController::completarRutinasCalendario', ['filter'=>'authGuard']);
