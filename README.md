# WorkoutRoutine

**WorkoutRoutine** es una aplicación web desarrollada en PHP (CodeIgniter 4) que permite a cualquier usuario crear, gestionar y realizar rutinas de entrenamiento. Está diseñada tanto para principiantes como para usuarios avanzados del mundo del fitness.

---

## Características principales

- Consulta de ejercicios con filtros avanzados
- Generador automático de rutinas basado en parámetros personalizados
- Creador de rutinas personalizadas
- Sistema de logros desbloqueables
- Registro de rutinas realizadas mediante calendario
- Ejecución guiada de rutinas (por repeticiones o por tiempo)
- Panel de administración completo (usuarios, roles, ejercicios, logros)
- Notificaciones y gestión del perfil de usuario

---

## Tecnologías utilizadas

- PHP 8.x (CodeIgniter 4)
- MySQL / MariaDB
- HTML5, CSS3, Bootstrap 5
- JavaScript, jQuery
- Librerías externas:
  - SweetAlert2
  - DataTables
  - FullCalendar
  - Select2
  - TinyMCE

---

## Estructura del proyecto

```
.
├── WorkoutRoutine/
├── ├── app/                    # Código principal de la aplicación
├── │   ├── Config/             # Archivos de configuración del sistema
├── │   ├── Controllers/        # Lógica de control de la aplicación
├── │   ├── Database/           # Migraciones y Seeds para la base de datos
├── │   ├── Filters/            # Filtros (middleware) para controlar acceso
├── │   ├── Helpers/            # Funciones auxiliares globales
├── │   ├── Language/           # Archivos de idiomas (en, es)
├── │   ├── Libraries/          # Librerías personalizadas
├── │   ├── Models/             # Clases modelo para acceso a datos
├── │   ├── Services/           # Servicios personalizados o inyectados
├── │   ├── ThirdParty/         # Librerías de terceros no gestionadas por Composer
├── │   └── Views/              # Vistas organizadas por módulos (usuario, rutina, etc.)
├── │       ├── ejercicio/
├── │       ├── rutina/
├── │       ├── usuario/
├── │       ├── logro/
├── │       ├── rol/
├── │       └── errors/
├── │           ├── cli/
├── │           └── html/
├── ├── public/                 # Carpeta accesible desde el navegador
├── │   ├── assets/             # Archivos estáticos
├── │   │   ├── css/
├── │   │   ├── js/
├── │   │   ├── fonts/
├── │   │   ├── img/            # Imágenes generales, avatares, ejercicios
├── │   │   ├── icons/
├── │   │   └── libs/           # Librerías JS y CSS externas (DataTables, SweetAlert, etc.)
└── │   └── templates/          # Plantillas visuales reutilizables
```

---

## Instalación local

Para ejecutar la aplicación en local, sigue estos pasos:

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/PERCEBAL98/WorkoutRoutine-PHP.git
   ```

2. **Importa la base de datos**
   - Abre phpMyAdmin o tu gestor de base de datos.
   - Crea una base de datos llamada `workoutbd`.
   - Importa el archivo `workoutbd.sql` incluido en el repositorio.

3. **Configura la conexión a la base de datos**
   - Abre el archivo `.env` en la raíz del proyecto.
   - Ajusta los datos de conexión:
     ```
     database.default.hostname = localhost
     database.default.database = workoutbd
     database.default.username = root
     database.default.password = 
     ```

4. **Crea un Virtual Host**
   - Para poder acceder a la aplicación con un dominio personalizado, crea un Virtual Host apuntando a la carpeta /public del proyecto y añade lo siguiente a tu hosts:
     ```
     127.0.0.1    workoutroutine.es
     ```
   - Asegúrate de configurar tu servidor Apache (XAMPP, Laragon, etc.) con el host:
     ```
     <VirtualHost *:80>
       DocumentRoot "C:/ruta/a/tu/proyecto/public"
       ServerName workoutroutine.es
     </VirtualHost>
     ```

5. **Levanta el servidor local**
   ```bash
   php spark serve
   ```
   Accede a la aplicación desde: [http://workoutroutine.es/](http://workoutroutine.es/)

---

## Usuario de prueba

Puedes acceder con el siguiente usuario de prueba:

- **Usuario:** `Usuario`
- **Contraseña:** `contraseña`

O bien, puedes registrarte libremente desde la pantalla de registro.

---

## Autor

**Nombre:** [David Ferrer Moya]  
**Email:** [davidferrermoya@gmail.com]  

---

## Licencia

Este proyecto ha sido desarrollado como Trabajo Final de Ciclo Formativo de Grado Superior.  
No se permite su redistribución sin autorización del autor.
