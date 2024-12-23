
// Función para formatear el valor en formato $XX.XXX,XX
function formatCurrency(value) {
    // Reemplazar comas por puntos y asegurarse de que sea un número
    let formattedValue = parseFloat(value.replace(/[^\d.-]/g, '')).toFixed(2);
    let [integer, decimal] = formattedValue.split('.');
    integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return '$' + integer + ',' + decimal;
}

// Función para validar solo números
function validarSoloNumeros(event) {
    const input = event.target;
    input.value = input.value.replace(/\D/g, ''); // Elimina todo lo que no sea número
}

// Función para validar el correo electrónico
function validarCorreo() {
    const correo = document.getElementById('correo');
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(correo.value)) {
        alert("Por favor, ingrese un correo electrónico válido.");
        return false;
    }
    return true;
}

// Función para validar la fecha de vencimiento MM/AA
// Función para validar la fecha de vencimiento (solo números y el formato MM/AA)
function validarFechaVencimiento(event) {
    const input = event.target;
    let value = input.value.replace(/[^\d/]/g, ''); // Permite solo números y barra "/"
    
    // Limita a 5 caracteres (MM/AA)
    if (value.length > 5) {
        value = value.slice(0, 5);
    }

    // Asegura que el formato sea MM/AA (con barra diagonal después de 2 dígitos del mes)
    if (value.length > 2 && value.charAt(2) !== '/') {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }

    // Actualiza el valor del campo con el formato correcto
    input.value = value;
}

// Asignar evento de validación al campo fecha_vencimiento
document.getElementById('fecha_vencimiento').addEventListener('input', validarFechaVencimiento);


// Función para validar el CVV (máximo 3 dígitos)
function validarCVV() {
    const cvv = document.getElementById('cvv');
    const regex = /^\d{3}$/;
    if (!regex.test(cvv.value)) {
        alert("El CVV debe tener 3 dígitos.");
        return false;
    }
    return true;
}

// Función para mostrar u ocultar campos del formulario de tarjeta
function toggleTarjetaCampos() {
    const metodoPago = document.getElementById('metodo_pago').value;
    const datosTarjeta = document.getElementById('datos_tarjeta');
    const tarjetaCampos = datosTarjeta.getElementsByTagName('input');
    const isTarjeta = metodoPago === '2';

    if (isTarjeta) {
        datosTarjeta.style.display = 'block';
        for (let input of tarjetaCampos) {
            input.setAttribute('required', 'true');
        }
    } else {
        datosTarjeta.style.display = 'none';
        for (let input of tarjetaCampos) {
            input.removeAttribute('required');
        }
    }
}

// Función para manejar el cambio de trámite
function cambiarTramite() {
    const tramiteSeleccionado = document.getElementById('tramite').selectedOptions[0];
    const valorTramite = tramiteSeleccionado.getAttribute('data-valor');
    const descripcionTramite = tramiteSeleccionado.getAttribute('data-descripcion');
    const monto = document.getElementById('monto');
    const descripcionTramiteField = document.getElementById('descripcion_tramite');
    const valorRecibo = document.getElementById('valor_recibo');
    const descripcionTramiteInput = document.getElementById('descripcion_tramite_input'); // Campo oculto para la descripción

    if (tramiteSeleccionado.value === "") {
        // Si no hay trámite seleccionado, restablecer los valores
        monto.value = "0.00";
        descripcionTramiteField.innerText = "Seleccione un trámite";
        valorRecibo.innerText = "$0.00";
        descripcionTramiteInput.value = ""; // Limpiar el campo oculto
    } else {
        // Asignar monto y descripcion
        monto.value = valorTramite;
        descripcionTramiteField.innerText = descripcionTramite;
        descripcionTramiteInput.value = descripcionTramite; // Asignar la descripción al campo oculto
        
        // Formatear y mostrar el valor del recibo
        valorRecibo.innerText = formatCurrency(valorTramite);
    }   
}

// Agregar eventos a los campos del formulario
document.getElementById('formulario').addEventListener('submit', function(event) {
    if (!validarCorreo()) {
        event.preventDefault(); // Prevenir el envío si la validación falla
    }
    if (document.getElementById('metodo_pago').value === '2') {
        if (!validarFechaVencimiento() || !validarCVV()) {
            event.preventDefault(); // Prevenir el envío si la validación falla
        }
    }
});

// Asignar eventos a los campos específicos
document.getElementById('tramite').addEventListener('change', cambiarTramite);
document.getElementById('metodo_pago').addEventListener('change', toggleTarjetaCampos);

// Validaciones de campos numéricos
document.getElementById('identificacion').addEventListener('input', validarSoloNumeros);
document.getElementById('telefono').addEventListener('input', validarSoloNumeros);
document.getElementById('numero_tarjeta').addEventListener('input', validarSoloNumeros);
document.getElementById('cvv').addEventListener('input', validarSoloNumeros);

