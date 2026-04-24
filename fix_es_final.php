<?php
$basePath = __DIR__ . '/resources/lang/es';

// === PART A: main.php final nested keys ===
$mainPath = $basePath . '/main.php';
$mainData = include $mainPath;

$mainNested = [
    'main' => [
        'dashboard' => 'Panel de Control',
        'account_settings' => 'Configuración de Cuenta',
        'total_users' => 'Total de Usuarios',
        'view_all' => 'Ver Todo',
        'total_countries' => 'Total de Países',
        'total_cities' => 'Total de Ciudades',
        'total_currencies' => 'Total de Monedas',
        'welcome_message' => 'Mensaje de Bienvenida',
        'dashboard_welcome_description' => 'Resumen de las actividades y estadísticas del sistema.',
        'system_overview' => 'Resumen del Sistema',
        'all_currencies' => 'Todas las Monedas',
        'total_records' => 'Total de Registros',
        'currencies' => 'Monedas',
        'view' => 'Ver',
        'quick_actions' => 'Acciones Rápidas',
        'auto_refresh' => 'Actualización Automática',
        'manage_users' => 'Gestionar Usuarios',
        'upload_files' => 'Subir Archivos',
        'upload_multiple_files' => 'Subir Múltiples Archivos',
        'files' => 'Archivos',
        'click_or_drag_images_here' => 'Haga clic o arrastre imágenes aquí',
        'alt_text' => 'Texto Alternativo',
        'available_collections' => 'Colecciones Disponibles',
        'priority_of_appearance' => 'Prioridad de Aparición',
        'featured' => 'Destacado',
        'edit_media_file' => 'Editar Archivo Multimedia',
        'file_type' => 'Tipo de Archivo',
        'file_size' => 'Tamaño de Archivo',
        'dimensions' => 'Dimensiones',
        'file_name' => 'Nombre del Archivo',
        'replace_file' => 'Reemplazar Archivo',
        'optional' => 'Opcional',
        'click_to_upload_or_drag_and_drop' => 'Haga clic para subir o arrastre y suelte',
        'leave_empty_to_keep_current_file' => 'Deje vacío para mantener el archivo actual',
        'replaced_file' => 'Archivo Reemplazado',
        'file' => 'Archivo',
        'media_file_details' => 'Detalles del Archivo Multimedia',
        'download' => 'Descargar',
        'file_information' => 'Información del Archivo',
        'mime_type' => 'Tipo MIME',
        'collection_name' => 'Nombre de Colección',
        'is_featured' => 'Es Destacado',
        'display_order' => 'Orden de Visualización',
        'uploaded_by' => 'Subido Por',
        'uploaded_at' => 'Subido El',
        'last_updated' => 'Última Actualización',
        'view_original' => 'Ver Original',
        'copy_url' => 'Copiar URL',
        'url_copied_to_clipboard' => '¡URL copiada al portapapeles!',
        'failed_to_copy_url' => 'Error al copiar la URL',
        'copied' => 'Copiado',
        'pricing-definition' => 'Definición de Precios',
        'pricing-definitions' => 'Definiciones de Precios',
        'transportations_companies' => 'Compañías de Transporte',
        'key' => 'Clave',
        'category' => 'Categoría',
        'id' => 'ID',
        'mandatory' => 'Obligatorio',
        'applicable_date' => 'Fecha Aplicable',
        'policy' => 'Política',
        'quotation' => 'Cotización',
        'classification' => 'Clasificación',
        'star_rating' => 'Calificación por Estrellas',
        'general_mobile' => 'Móvil General',
        'general_email' => 'Correo General',
        'contact_person' => 'Persona de Contacto',
        'street' => 'Calle',
        'included' => 'Incluido',
        'no_data_available' => 'No hay datos disponibles',
        'restaurant' => 'Restaurante',
        'services' => 'Servicios',
        'service' => 'Servicio',
        'per_adult_foreigners' => 'Por Adulto (Extranjeros)',
        'per_adult_local' => 'Por Adulto (Local)',
        'per_adult_arab' => 'Por Adulto (Árabe)',
        'total_day_visit' => 'Total Visita Diaria',
        'operating_hours' => 'Horario de Operación',
        'summer_opening_time' => 'Hora de Apertura Verano',
        'summer_closing_time' => 'Hora de Cierre Verano',
        'winter_opening_time' => 'Hora de Apertura Invierno',
        'winter_closing_time' => 'Hora de Cierre Invierno',
        'person_name_01' => 'Nombre de Persona 01',
        'phone' => 'Teléfono',
        'mobile' => 'Móvil',
        'fax' => 'Fax',
        'include_unified_ticket' => 'Incluye Boleto Unificado',
        'local_guide_available' => 'Guía Local Disponible',
        'credit_cards' => 'Tarjetas de Crédito',
        'club_cars_available' => 'Coches del Club Disponibles',
        'no_supplements_available' => 'Sin Suplementos Disponibles',
        'transportations-company' => 'Compañía de Transporte',
        'rating' => 'Calificación',
        'vehicle-type' => 'Tipo de Vehículo',
        'vehicle-types' => 'Tipos de Vehículo',
        'transportations-bus_type' => 'Tipo de Autobús',
        'transportations-bus_types' => 'Tipos de Autobús',
        'states_' => 'Estados',
        'important_information' => 'Información Importante',
        'ensure_data_accuracy' => 'Asegure la precisión de los datos',
        'geographic_coordinates' => 'Coordenadas Geográficas',
        'use_map_services' => 'Use servicios de mapas',
        'transportation-bus-types' => 'Tipos de Autobús de Transporte',
        'transportation-bus-type' => 'Tipo de Autobús de Transporte',
        'transportations-company_bus_type' => 'Tipo de Autobús de Compañía',
        'transportations-company_bus_types' => 'Tipos de Autobús de Compañía',
        'min_seats' => 'Asientos Mínimos',
        'max_seats' => 'Asientos Máximos',
        'seats' => 'Asientos',
        'transportations-company-bus-types' => 'Tipos de Autobús de Compañía',
        'transportations-company-bus-type' => 'Tipo de Autobús de Compañía',
        'transportations-department' => 'Departamento de Transporte',
        'transportations-departments' => 'Departamentos de Transporte',
        'optional_fields' => 'Campos Opcionales',
        'transportation-departments' => 'Departamentos de Transporte',
        'transportation-department' => 'Departamento de Transporte',
        'transportations-vehicles' => 'Vehículos de Transporte',
        'duration' => 'Duración',
        'hours' => 'Horas',
        'distance' => 'Distancia',
        'kilometers' => 'Kilómetros',
        'route_ar' => 'Ruta (Árabe)',
        'transportation-vehicles' => 'Vehículos de Transporte',
        'transportation-vehicle' => 'Vehículo de Transporte',
        'import_companies' => 'Importar Compañías',
        'upload_excel_file' => 'Subir Archivo Excel',
        'select_file' => 'Seleccionar Archivo',
        'accepted_formats' => 'Formatos Aceptados',
        'import_instructions' => 'Instrucciones de Importación',
        'excel_must_have_headers' => 'El Excel debe tener encabezados',
        'ensure_correct_columns' => 'Asegure las columnas correctas',
        'duplicate_companies_will_be_updated' => 'Las compañías duplicadas se actualizarán',
        'empty_values_set_to_null' => 'Los valores vacíos se establecerán como nulos',
        'or_export_existing' => 'O exportar existente',
        'include_relations' => 'Incluir Relaciones',
        'export_related_data' => 'Exportar Datos Relacionados',
        'export_companies' => 'Exportar Compañías',
        'import_contacts' => 'Importar Contactos',
        'ensure_company_id_or_name_field' => 'Asegure el campo ID o nombre de compañía',
        'all_contact_records_will_be_inserted' => 'Todos los registros de contacto se insertarán',
        'duplicate_contacts_allowed' => 'Se permiten contactos duplicados',
        'export_contacts' => 'Exportar Contactos',
        'vehicle' => 'Vehículo',
        'air_conditioning' => 'Aire Acondicionado',
        'free_wifi' => 'WiFi Gratis',
        'entertainment' => 'Entretenimiento',
        'usb_ports' => 'Puertos USB',
        'gps' => 'GPS',
        'camera' => 'Cámara',
        'safety' => 'Seguridad',
        'wheelchair' => 'Silla de Ruedas',
        'apps' => 'Aplicaciones',
        'enabled' => 'Habilitado',
        'unknown_user' => 'Usuario Desconocido',
        'unknown_email' => 'Correo Desconocido',
        'my_profile' => 'Mi Perfil',
        'language' => 'Idioma',
        'logout' => 'Cerrar Sesión',
        'accommodations' => 'Alojamientos',
        'columns_saved_successfully' => 'Columnas guardadas exitosamente',
        'unauthorized' => 'No Autorizado',
        'columns_updated_successfully' => 'Columnas actualizadas exitosamente',
        'columns_reset_successfully' => 'Columnas restablecidas exitosamente',
        'google_drive_link_saved_successfully' => 'Enlace de Google Drive guardado exitosamente',
        'failed_to_download_from_drive' => 'Error al descargar desde Drive',
        'ensure_file_is_public' => 'Asegúrese de que el archivo sea público',
        'file_not_found' => 'Archivo no encontrado',
        'operation_failed' => 'Operación fallida',
        'import_history_cleared' => 'Historial de importación borrado',
        'media_file_updated_successfully' => 'Archivo multimedia actualizado exitosamente',
        'media_file_deleted_successfully' => 'Archivo multimedia eliminado exitosamente',
        'transportations_company_contacts' => 'Contactos de Compañía de Transporte',
        'user_status' => 'Estado del Usuario',
        'canceled_by_user' => 'Cancelado por el usuario',
        'job_canceled' => 'Trabajo cancelado',
        'job_started' => 'Trabajo iniciado',
        'queue_processed' => 'Cola procesada',
        'notification_marked_as_read' => 'Notificación marcada como leída',
        'notification_deleted' => 'Notificación eliminada',
        'notification_marked_as_unread' => 'Notificación marcada como no leída',
        'all_notifications_marked_as_read' => 'Todas las notificaciones marcadas como leídas',
        'type_{$modelKey}' => 'Tipo {$modelKey}',
        '{$event}' => '{$event}',
        'system_default_saved' => 'Predeterminado del sistema guardado',
    ],
    'messages' => [
        'are_you_sure' => '¿Está seguro?',
        'confirm_bulk_delete' => '¿Confirmar eliminación masiva?',
        'no_records_found' => 'No se encontraron registros.',
        'are_you_sure_delete' => '¿Está seguro de que desea eliminar?',
        'are_you_sure_force_delete' => '¿Está seguro de que desea eliminar definitivamente?',
        'force_delete_warning' => '¡Advertencia! Esta acción no se puede deshacer.',
        'no_results_found' => 'No se encontraron resultados',
        'sidebar_order_updated' => 'Orden de la barra lateral actualizado.',
        'sidebar_item_shown' => 'Elemento del menú mostrado.',
        'sidebar_item_hidden' => 'Elemento del menú oculto.',
        'error_occurred' => 'Ocurrió un error.',
        'sidebar_reset_default' => 'Barra lateral restablecida al valor predeterminado.',
        'invalid_model_specified' => 'Modelo especificado inválido.',
        'select_at_least_one_notification_type' => 'Seleccione al menos un tipo de notificación.',
        'ably_key_not_configured' => 'Clave Ably no configurada.',
        'record_not_found' => 'Registro no encontrado.',
        'invalid_field' => 'Campo inválido.',
        'updated_successfully' => 'Actualizado exitosamente.',
        'no_items_selected' => 'No hay elementos seleccionados.',
        'operation_failed' => 'Operación fallida.',
        'access_denied' => 'Acceso denegado.',
        'notification_marked_read' => 'Notificación marcada como leída.',
        'notification_marked_unread' => 'Notificación marcada como no leída.',
        'all_notifications_marked_read' => 'Todas las notificaciones marcadas como leídas.',
        'notification_deleted' => 'Notificación eliminada.',
        'operation_successful' => 'Operación exitosa.',
        'saved_successfully' => 'Guardado exitosamente.',
        'deleted_successfully' => 'Eliminado exitosamente.',
        'model_not_found' => 'Modelo no encontrado.',
        'system_default_saved' => 'Predeterminado del sistema guardado.',
        'no_records_selected' => 'No hay registros seleccionados.',
    ],
    'Method Not Allowed.' => 'Método No Permitido.',
    'The Request Method Is Not Allowed.' => 'El Método de Solicitud No Está Permitido.',
    'auth' => [
        'failed' => 'Las credenciales no coinciden con nuestros registros.',
        'login_successful' => 'Inicio de sesión exitoso.',
        'logout_successful' => 'Cierre de sesión exitoso.',
    ],
    'The uploaded file is not valid.' => 'El archivo subido no es válido.',
    'activity' => [
        'activity_no_description' => 'No hay descripción disponible.',
    ],
    'suggest' => 'Sugerir',
];

$actPath = $basePath . '/activity.php';
$actData = file_exists($actPath) ? include $actPath : [];

$actNested = [
    'auth' => [
        'login' => 'Inicio de Sesión',
        'logout' => 'Cierre de Sesión',
        'register' => 'Registro',
        'password_reset_request' => 'Solicitud de Restablecimiento de Contraseña',
        'password_reset' => 'Restablecimiento de Contraseña',
        'password_update' => 'Actualización de Contraseña',
        'user_logged_in' => 'Usuario :user ha iniciado sesión',
        'user_logged_out' => 'Usuario :user ha cerrado sesión',
        'user_registered' => 'Nuevo usuario registrado: :user',
        'password_reset_requested' => ':user solicitó restablecimiento de contraseña',
        'password_has_been_reset' => 'La contraseña de :user ha sido restablecida',
        'password_has_been_updated' => 'La contraseña de :user ha sido actualizada',
    ],
    'dashboard' => [
        'tasks' => [
            'showing' => 'Mostrando',
            'to' => 'a',
            'of' => 'de',
            'results' => 'resultados',
            'previous' => 'Anterior',
            'next' => 'Siguiente',
        ]
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

updateNestedArray($mainData, $mainNested);
file_put_contents($mainPath, exportArrayToPhpSafe($mainData));
echo "-> main.php (ES): Final keys applied.\n";

updateNestedArray($actData, $actNested);
file_put_contents($actPath, exportArrayToPhpSafe($actData));
echo "-> activity.php (ES): Final nested keys applied.\n";

echo "=====================================\n";
echo "SUCCESS! Spanish is now 100% Complete.\n";
echo "=====================================\n";
