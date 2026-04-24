<?php

$basePath = __DIR__ . '/resources/lang/es';

if (!is_dir($basePath)) {
    die("Error: Spanish language directory not found at $basePath\n");
}

$es_translations = [
    'main.php' => [
        "banner_image" => "Imagen del Banner",
        "whatsapp" => "WhatsApp",
        "emails" => "Correos Electrónicos",
        "mcp" => "Herramientas de Integración",
        "communications" => "Comunicaciones",
        "integrations" => "Integraciones",
        "google_maps" => "Google Maps",
        "google_drive" => "Google Drive",
        "coming_soon" => "Próximamente",
        "view_profile" => "Ver Perfil",
        "total_reservations" => "Total de Reservas",
        "total_types" => "Total de :types",
        "welcome_to" => "Bienvenido a",
        "deleted_at" => "Eliminado el",
        "createdBy" => "Creado por",
        "updatedBy" => "Actualizado por",
        "creator" => "Creador",
        "updater" => "Actualizador",
        "activated" => "Activado",
        "deactivated" => "Desactivado",
        "pending" => "Pendiente",
        "user_id" => "Usuario",
        "users_" => "Usuarios",
        "get_started" => "Comenzar",
        "manage_system_types" => "Gestionar :types del sistema",
        "add_new_type" => "Agregar Nuevo :type",
        "required_fields" => "Campos Obligatorios",
        "there_must_be" => "Debe haber",
        "available" => "Disponible",
        "available_tables" => "Mesas Disponibles",
        "select_type_first" => "Seleccione :type primero",
        "_models" => "Modelos",
        "models" => "Modelos",
        "_system" => "Sistema",
        "_default" => "Por defecto",
        "default" => "Por defecto",
        "restored" => "restaurado",
        "info" => "información",
        "copy" => "Copiar",
        "none_required" => "Ninguno Requerido",
        "paste" => "Pegar",
        "report" => "Informe",
        "reports" => "Informes",
        "apply_filters" => "Aplicar Filtros",
        "are_you_sure_reset_columns" => "¿Está seguro de que desea restablecer las columnas por defecto?",
        "monday" => "Lunes",
        "tuesday" => "Martes",
        "wednesday" => "Miércoles",
        "thursday" => "Jueves",
        "friday" => "Viernes",
        "saturday" => "Sábado",
        "sunday" => "Domingo",
        "holiday" => "Día Festivo",
        "my_modules" => "Mis Módulos",
        "subscription" => "Suscripción",
        "subscriptions" => "Suscripciones",
        "active_modules" => "Módulos Activos",
        "total_modules" => "Módulos Totales",
        "expiring_soon" => "Expira Pronto",
        "unlimited" => "Ilimitado",
        "cancel_selection" => "Cancelar Selección",
        "activate" => "Activar",
        "deactivate" => "Desactivar",
        "submit" => "Enviar",
        "filter" => "Filtrar",
        "filters" => "Filtros",
        "reset" => "Restablecer",
        "application" => "Aplicación",
        "remove" => "Eliminar",
        "hide" => "Ocultar",
        "send" => "Enviar",
        "sent" => "Enviado",
        "currently" => "Actualmente",
        "select_all" => "Seleccionar Todo",
        "message_cannot_be_empty" => "El mensaje no puede estar vacío",
        "something_went_wrong" => "Algo salió mal",
        "adults" => "Adultos",
        "arrival_date" => "Fecha de Llegada",
        "departure_date" => "Fecha de Salida",
        "nights" => "Noches",
        "grand_total" => "Total General",
        "fake_data" => "Datos Falsos",
        "import_google_drive" => "Importar vía URL",
        "enter_google_drive_link" => "Ingresar URL de datos (ej. Google Drive, iCal, etc.)",
        "drive_update_confirm_question" => "¿Desea continuar?",
        "invalid_google_drive_link" => "Enlace no válido. Asegúrese de que esté copiado correctamente.",
        "select_status" => "Seleccionar Estado",
        "name_asc" => "Nombre (A-Z)",
        "name_desc" => "Nombre (Z-A)",
        "newest" => "Más Reciente",
        "oldest" => "Más Antiguo",
        "show_hide_columns" => "Mostrar/Ocultar Columnas",
        "clear" => "Limpiar",
        "general" => "General",
        "geographic" => "Geográfico",
        "relationships" => "Relaciones",
        "dates" => "Fechas",
        "bulk_edit" => "Edición Masiva",
        "choose_file" => "Elegir archivo",
        "no_file_chosen" => "Ningún archivo elegido",
        "distributed_across" => "Distribuido a través de",
        "country_singular" => "país"
    ]
];

function updateNestedArray(&$original, $newValues) {
    foreach ($newValues as $key => $value) {
        if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
            updateNestedArray($original[$key], $value);
        } else {
            $original[$key] = $value;
        }
    }
}

function exportArrayToPhpSafeHelper($array, $indent = 1) {
    $spaces = str_repeat("    ", $indent);
    $content = "[\n";
    foreach ($array as $key => $value) {
        $safeKey = addcslashes((string)$key, "'\\");
        if (is_array($value)) {
            $content .= $spaces . "'$safeKey' => " . exportArrayToPhpSafeHelper($value, $indent + 1) . ",\n";
        } else {
            $safeValue = addcslashes((string)$value, "'\\");
            $content .= $spaces . "'$safeKey' => '$safeValue',\n";
        }
    }
    $content .= str_repeat("    ", $indent - 1) . "]";
    return $content;
}

function exportArrayToPhpSafe($array) {
    return "<?php\n\nreturn " . exportArrayToPhpSafeHelper($array) . ";\n";
}

$count = 0;

foreach ($es_translations as $filename => $translations) {
    $filePath = $basePath . '/' . $filename;
    
    if (file_exists($filePath)) {
        $existingData = include $filePath;
        if (!is_array($existingData)) {
            $existingData = [];
        }
    } else {
        $existingData = [];
    }
    
    updateNestedArray($existingData, $translations);
    $count += count($translations);
    
    $newContent = exportArrayToPhpSafe($existingData);
    file_put_contents($filePath, $newContent);
    echo "-> $filename: Updated with 100 translated Spanish values.\n";
}

echo "=====================================\n";
echo "SUCCESS! Applied Part 1 ($count keys) for Spanish.\n";
echo "=====================================\n";

?>
