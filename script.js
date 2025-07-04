// Función para validar el formulario antes de enviarlo
function validarFormulario() {
    // Obtener los campos obligatorios
    const primerNombre = document.querySelector('input[name="Primer_Nombre"]').value.trim();
    const primerApellido = document.querySelector('input[name="Primer_Apellido"]').value.trim();
    const cedula = document.querySelector('input[name="Cedula"]').value.trim();
    const telefono = document.querySelector('input[name="Teléfono"]').value.trim();
    const fechaNacimiento = document.querySelector('input[name="Fecha_Nacimiento"]').value;
    const correo = document.querySelector('input[name="Correo"]').value.trim();

    // Validar campos obligatorios
    if (!primerNombre) {
        alert('Por favor, ingrese su primer nombre');
        document.querySelector('input[name="Primer_Nombre"]').focus();
        return false;
    }

    if (!primerApellido) {
        alert('Por favor, ingrese su primer apellido');
        document.querySelector('input[name="Primer_Apellido"]').focus();
        return false;
    }

    if (!cedula) {
        alert('Por favor, ingrese su número de cédula');
        document.querySelector('input[name="Cedula"]').focus();
        return false;
    }

    if (!telefono) {
        alert('Por favor, ingrese su número de teléfono');
        document.querySelector('input[name="Teléfono"]').focus();
        return false;
    }

    if (!fechaNacimiento) {
        alert('Por favor, seleccione su fecha de nacimiento');
        document.querySelector('input[name="Fecha_Nacimiento"]').focus();
        return false;
    }

    if (!correo) {
        alert('Por favor, ingrese su correo electrónico');
        document.querySelector('input[name="Correo"]').focus();
        return false;
    }

    // Validar formato de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        alert('Por favor, ingrese un correo electrónico válido');
        document.querySelector('input[name="Correo"]').focus();
        return false;
    }

    // Validar que la fecha de nacimiento no sea futura
    const fechaActual = new Date();
    const fechaNac = new Date(fechaNacimiento);
    if (fechaNac > fechaActual) {
        alert('La fecha de nacimiento no puede ser futura');
        document.querySelector('input[name="Fecha_Nacimiento"]').focus();
        return false;
    }

    // Validar que la cédula sea un número válido
    if (isNaN(cedula) || cedula <= 0) {
        alert('Por favor, ingrese un número de cédula válido');
        document.querySelector('input[name="Cedula"]').focus();
        return false;
    }

    // Si todo está bien, mostrar confirmación
    if (confirm('¿Está seguro de que desea registrar estos datos?')) {
        return true;
    } else {
        return false;
    }
}

// Función para agregar etiquetas visuales a campos obligatorios
function marcarCamposObligatorios() {
    const camposObligatorios = document.querySelectorAll('input[required]');
    camposObligatorios.forEach(campo => {
        campo.style.borderLeft = '4px solid #ff6b6b';
    });
}

// Función para limpiar validaciones en tiempo real
function limpiarValidacion(campo) {
    campo.style.borderColor = '';
    campo.style.borderLeft = '4px solid #ff6b6b';
}

// Función para validar correo en tiempo real
function validarCorreoTiempoReal(campo) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (campo.value && !emailRegex.test(campo.value)) {
        campo.style.borderColor = '#ff6b6b';
        campo.style.borderLeft = '4px solid #ff6b6b';
    } else if (campo.value) {
        campo.style.borderColor = '#51cf66';
        campo.style.borderLeft = '4px solid #51cf66';
    } else {
        limpiarValidacion(campo);
    }
}

// Función para validar número de cédula en tiempo real
function validarCedulaTiempoReal(campo) {
    if (campo.value && (isNaN(campo.value) || campo.value <= 0)) {
        campo.style.borderColor = '#ff6b6b';
        campo.style.borderLeft = '4px solid #ff6b6b';
    } else if (campo.value) {
        campo.style.borderColor = '#51cf66';
        campo.style.borderLeft = '4px solid #51cf66';
    } else {
        limpiarValidacion(campo);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Marcar campos obligatorios
    marcarCamposObligatorios();

    // Agregar validación en tiempo real para correo
    const campoCorreo = document.querySelector('input[name="Correo"]');
    if (campoCorreo) {
        campoCorreo.addEventListener('input', function() {
            validarCorreoTiempoReal(this);
        });
    }

    // Agregar validación en tiempo real para cédula
    const campoCedula = document.querySelector('input[name="Cedula"]');
    if (campoCedula) {
        campoCedula.addEventListener('input', function() {
            validarCedulaTiempoReal(this);
        });
    }

    // Agregar validación en tiempo real para campos obligatorios
    const camposObligatorios = document.querySelectorAll('input[required]');
    camposObligatorios.forEach(campo => {
        campo.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#51cf66';
                this.style.borderLeft = '4px solid #51cf66';
            } else {
                limpiarValidacion(this);
            }
        });
    });
}); 