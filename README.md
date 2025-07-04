
# 🧠 Emoción Vital - Sistema de Consultas Psicológicas

![Banner](banner.png)

👥 Integrantes del Proyecto

- [@Angelo Lelli](https://github.com/angelolelli)
- [@Alberth Espinoza](https://github.com/Aruajeg)
- [@Janet Ochoa](https://github.com/Ja-n3t-777)
- [@Luis Linarez](https://github.com/LuisAngelLinarez)

## 🌟 Definición del Sistema  
Solución tecnológica que centraliza la gestión de consultas psicológicas (presenciales/virtuales), optimizando el acceso a terapias personalizadas para garantizar un seguimiento emocional continuo y accesible.

VIDEO del Sistema: https://drive.google.com/file/d/1vWPq0B7puKwewc8CZF70USb37M7KjJ4j/view?usp=sharing

# 🚀 Funcionalidad

## 1. 🏡 Página de Bienvenida
El portal de bienvenida es un entorno informativo que incluye las siguientes secciones clave:

| Sección                  | Descripción                                                                  |
|--------------------------|------------------------------------------------------------------------------|
| **EMOCIÓN VITAL-BANNER** | Una bienvenida a el espacio de consultas psicológicas.                       |
| **NUESTROS SERVICIOS**   | Ofrecimiento de servicios para ADULTOS, ADOLESCENTES, PARA PAREJA, INFANTES. |
| **REDES SOCIALES**       | Sección rapida para conocer y acceder a las redes sociales del consultorio.  |
| **TIPOS DE CONSULTA**    | Sugerencias para optar por el tipo de consulta deseado (PRESNEICLA/ONLINE)   |
| **OBJETIVOS**            | Sección donde se visualiza la Misión y Visión del consultorio Psicologico.   |

## 2. ✅ Ingresar al Sistema
Para acceder al sistema los usuarios estando en la pagina de Bienvenida, deberan seguir estos pasos:

1. Haz clic en el botón **`INGRESAR`** ubicado en la parte superior derecha de la pantalla.

## Inicio de Sesión
1. Los usuarios registrados deben ingresar sus credenciales:
    - 📧 **Correo electrónico**
    - 🔒 **Contraseña**

## Registro de Nuevos Usuarios
Si aún no tienes una cuenta, sigue estos pasos:
1. Haz clic en **`REGISTRATE`**.
2. Completa los cuadros de texto con tus datos:
    - 📧 **Correo electrónico**
    - 👤 **Nombre de usuario**
    - 🔒 **Contraseña**
    - 🔒 **Repite la contraseña** 

¡Listo! Ya podrás acceder al sistema con tus nuevas credenciales.
> ⚠️ Recuerda guardar tus datos de acceso en un lugar seguro.

## Gestión de Citas

El área de Gestion de citas permite solicitar, modificar, consultar y cancelar citas, con campos para seleccionar paciente, psicólogo, tipo de consulta (online/presencial), fecha y motivo.

Tambien se Integra la API de Google Calendar para sincronizar agendas, destacando por su practicidad.

## Registro de Datos

El sistema incluye formularios detallados para agregar pacientes y psicólogos, con validación de documentos y opciones para listas desplegables (ej. tipo de documento o sexo).

## Redes Sociales

El área de redes sociales centraliza enlaces a plataformas como WhatsApp, Instagram y Facebook mediante la herramienta Atom.bio, fomentando la interacción y el seguimiento.

## Dashboard Administrativo

El dashboard a diferente del dashboard del Paciente muestra métricas clave, menús laterales para navegación rápida y tablas de registros (pacientes y psicólogos), diseñado para optimizar la gestión administrativa.

# Guía de Instalación y Configuración
Este apartado te guiará paso a paso en la instalación y configuración del entorno necesario para ejecutar el proyecto.

## 📥 1. Descargar e Instalar XAMPP con PHP

### Descargar XAMPP
1. Visita la [página oficial de XAMPP](https://www.apachefriends.org/es/index.html).
2. Descarga el instalador para tu sistema operativo.

### Instalar XAMPP
1. Ejecuta el instalador descargado
2. Selecciona los componentes a instalar (mínimo Apache, MySQL y PHP)
3. Elige directorio de instalación (ej: C:\xampp)
4. Completa el proceso de instalación

### Verificar la instalación
1. Una vez que XAMPP se haya instalado, abre el **Panel de Control de XAMPP** (se encuentra en el directorio donde lo instalaste, como `C:\xampp\xampp-control.exe`).  
  
2. Inicia los servicios **Apache** y **MySQL** desde el panel de control.

3. Abre tu navegador y escribe en la barra de direcciones:  
  - [`http://localhost`](http://localhost)  
  - [`http://localhost/phpmyadmin/`](http://localhost/phpmyadmin/)  

Deberías ver la página de inicio de XAMPP o phpMyAdmin.

### Verificar la versión de PHP
Ejecuta el siguiente comando en la terminal (**CMD**):  
    ```sh
    php --version
    ```
Deberías ver la versión de PHP instalada en tu sistema.

## 📥 2. Descargar e Instalar Git

### 1. Descargar Git
🌐 Visita la página oficial de descarga de Git: [Descargar Git](https://git-scm.com/downloads)  
🔻 Selecciona la versión compatible con tu sistema operativo.

### 2. Instalar Git
🛠️ Sigue estos pasos:
- Ejecuta el instalador descargado
- Acepta los términos de licencia
- **Importante:** Selecciona la opción:  
  `Git from the command line and also from 3rd-party software`  
  (Esto integra Git con la línea de comandos de Windows)
- Completa el proceso con las configuraciones predeterminadas

### 3. Verificar la instalación de Git
✅ Para confirmar que Git se instaló correctamente:
1. Abre el símbolo del sistema (**CMD**)
2. Ejecuta:
    ```sh
    git --version
    ```

Deberías ver la versión de Git instalada en tu sistema.

## 🐙 3. Clonar un Repositorio de GitHub

### 1. Obtener la URL del repositorio
🔹 Ve al repositorio en GitHub que deseas clonar 
  ```plaintext
  https://github.com/Aruajeg/Emocion_Vital-T_T
  ```
[Link de este repositorio](https://github.com/Aruajeg/Emocion_Vital-T_T)

🔹 Haz clic en el botón verde **"Code"**  
🔹 Copia la URL HTTPS

### 2. Clonar el repositorio
🖥️ Desde la terminal (**CMD**):

1. Navega al directorio htdocs de XAMPP:
  ```sh
  cd C:\xampp\htdocs
  ```
  
  También puedes navegar manualmente a:
  ```sh
  C:\xampp\htdocs
  ```

2. Ejecuta el comando de clonación:
  ```sh
  git clone https://github.com/Aruajeg/Emocion_Vital-T_T
  ```

### 3. Acceder al directorio del proyecto
📂 Después de clonar:
  ```sh
  cd Emocion_Vital-T_T
  ```
  O ingresa a la carpeta `htdocs` para verificar el repositorio.

## 💥 4. Instalar librerias necesarias

El primero comando a utilizar en el terminal de Visual Studio es para librerías de google.
  ```sh
  composer require google/apiclient
  ```
El segundo para corregir problemas.
  ```sh
  composer require --dev barryvdh/laravel-ide-helper
  ```
Además de añadir por supuesto la instalación del composer.