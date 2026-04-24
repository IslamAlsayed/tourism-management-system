<?php

$basePath = __DIR__ . '/resources/lang/es';

if (!is_dir($basePath)) {
    die("Error: Spanish language directory not found at $basePath\n");
}

$es_translations = [
    'sidebar.php' => [
        "notification settings" => "Configuración de Notificaciones",
        "general" => "General",
        "backup" => "Copia de Seguridad",
        "booking" => "Reserva",
        "integration" => "Integración",
        "theme_customizer" => "Personalizador de Tema",
        "all hotels" => "Todos los Hoteles",
        "add hotel" => "Agregar Hotel",
        "hotel categories" => "Categorías de Hotel",
        "all resorts" => "Todos los Resorts",
        "add resort" => "Agregar Resort",
        "resort facilities" => "Instalaciones del Resort",
        "tourist camps" => "Campamentos Turísticos",
        "Page under construction" => "Página en construcción",
        "all camps" => "Todos los Campamentos",
        "add camp" => "Agregar Campamento",
        "camp activities" => "Actividades del Campamento",
        "all hostels" => "Todos los Hostales",
        "add hostel" => "Agregar Hostal",
        "all lodges" => "Todos los Alojamientos",
        "add lodge" => "Agregar Alojamiento",
        "lodge features" => "Características del Alojamiento",
        "hotel apartments" => "Apartamentos de Hotel",
        "all apartments" => "Todos los Apartamentos",
        "add apartment" => "Agregar Apartamento",
        "apartment amenities" => "Comodidades del Apartamento",
        "add room" => "Agregar Habitación",
        "room availability" => "Disponibilidad de Habitaciones",
        "type features" => "Características del Tipo",
        "room names" => "Nombres de Habitaciones",
        "all room names" => "Todos los Nombres de Habitaciones",
        "add room name" => "Agregar Nombre de Habitación",
        "name templates" => "Plantillas de Nombres",
        "restaurant" => "Restaurante",
        "food management" => "Gestión de Alimentos",
        "food & beverage" => "Alimentos y Bebidas",
        "car rental" => "Alquiler de Coches",
        "limousine transfers" => "Traslados en Limusina",
        "air transport" => "Transporte Aéreo",
        "air transports" => "Transportes Aéreos",
        "all air transports" => "Todos los Transportes Aéreos",
        "create air transport" => "Crear Transporte Aéreo",
        "import air transports" => "Importar Transportes Aéreos",
        "airline" => "Aerolínea",
        "all airlines" => "Todas las Aerolíneas",
        "create airline" => "Crear Aerolínea",
        "import airlines" => "Importar Aerolíneas",
        "airlines" => "Aerolíneas",
        "charter companies" => "Compañías Chárter",
        "cargo airlines" => "Aerolíneas de Carga",
        "aircraft operators" => "Operadores de Aeronaves",
        "vehicles" => "Vehículos",
        "tourist buses" => "Autobuses Turísticos",
        "transport vehicles" => "Vehículos de Transporte",
        "tourist transport companies" => "Compañías de Transporte Turístico",
        "companies" => "Compañías",
        "departments" => "Departamentos",
        "bus types" => "Tipos de Autobuses",
        "company bus types" => "Tipos de Autobuses de Compañía",
        "4x4 vehicles" => "Vehículos 4x4",
        "crossings & ports" => "Cruces y Puertos",
        "international airports" => "Aeropuertos Internacionales",
        "domestic airports" => "Aeropuertos Nacionales",
        "seaports" => "Puertos Marítimos",
        "train stations" => "Estaciones de Tren",
        "suppliers & providers" => "Proveedores y Suministradores",
        "agents" => "Agentes",
        "suppliers" => "Proveedores",
        "providers" => "Suministradores",
        "types of airlines" => "Tipos de Aerolíneas",
        "customers" => "Clientes",
        "currencies & finance" => "Monedas y Finanzas",
        "activities" => "Actividades",
        "general activities" => "Actividades Generales",
        "desert activities" => "Actividades en el Desierto",
        "cultural activities" => "Actividades Culturales",
        "marine activities" => "Actividades Marinas",
        "water sports" => "Deportes Acuáticos",
        "diving" => "Buceo",
        "swimming" => "Natación",
        "boats & cruises" => "Barcos y Cruceros",
        "entrance fees" => "Tarifas de Entrada",
        "visa & regulations" => "Visa y Regulaciones",
        "visa types" => "Tipos de Visa",
        "visa requirements" => "Requisitos de Visa",
        "taxes" => "Impuestos",
        "city tax" => "Impuesto Municipal",
        "service tax" => "Impuesto de Servicio",
        "sales tax" => "Impuesto de Ventas",
        "APIs" => "APIs",
        "whatsapp API" => "API de WhatsApp",
        "payment APIs" => "APIs de Pago",
        "maps APIs" => "APIs de Mapas",
        "quotation system" => "Sistema de Cotización",
        "off season" => "Fuera de Temporada",
        "low season" => "Temporada Baja",
        "moderate season" => "Temporada Media",
        "high season" => "Temporada Alta",
        "peak season" => "Temporada Alta Pico",
        "building tourist programs" => "Creación de Programas Turísticos",
        "system administration" => "Administración del Sistema",
        "sidebar manager" => "Gestor de la Barra Lateral",
        "caches" => "Cachés",
        "caches management" => "Gestión de Cachés",
        "quick tools" => "Herramientas Rápidas",
        "update profile" => "Actualizar Perfil",
        "languages" => "Idiomas",
        "languages management" => "Gestión de Idiomas",
        "system languages management" => "Gestión de Idiomas del Sistema",
        "view languages" => "Ver Idiomas",
        "create language" => "Crear Idioma",
        "all languages" => "Todos los Idiomas",
        "add_new_language" => "Agregar Nuevo Idioma",
        "language_name" => "Nombre del Idioma",
        "language_code" => "Código del Idioma",
        "rooms types" => "Tipos de Habitaciones",
        "topic" => "Tema",
        "topics" => "Temas",
        "subscription" => "Suscripción",
        "subscriptions" => "Suscripciones",
        "my modules" => "Mis Módulos",
        "all subscriptions" => "Todas las Suscripciones",
        "soon" => "Pronto",
        "new" => "Nuevo",
        "updated" => "Actualizado",
        "updating" => "Actualizando",
        "updating..." => "Actualizando...",
        "inprogress" => "En Curso",
        "under_maintenance" => "En Mantenimiento",
        "tested" => "Probado",
        "testing" => "Probando",
        "editing..." => "Editando...",
        "done" => "Hecho",
        "mcp" => "MCP",
        "google maps" => "Google Maps",
        "google drive" => "Google Drive",
        "communications" => "Comunicaciones",
        "emails" => "Correos Electrónicos",
        "whatsapp" => "WhatsApp",
        "automation_settings" => "Configuración de Automatización (n8n)",
        "translation manager" => "Gestor de Traducción"
    ],
    'automation.php' => [
        "automation_settings" => "Configuración de Automatización (n8n)",
        "add_new_webhook" => "Agregar Nuevo Webhook (n8n)",
        "edit_webhook" => "Editar Webhook",
        "friendly_name" => "Nombre Amigable",
        "webhook_url" => "URL del Webhook",
        "event_type" => "Tipo de Evento",
        "all_events" => "Todos los Eventos (*)",
        "secret_token" => "Token Secreto (Opcional)",
        "update_bridge" => "Actualizar Puente",
        "connect_to_n8n" => "Conectar a n8n",
        "active_automation_bridges" => "Puentes de Automatización Activos",
        "name" => "Nombre",
        "event" => "Evento",
        "status" => "Estado",
        "actions" => "Acciones",
        "active" => "Activo",
        "paused" => "Pausado",
        "recent_synchronizations" => "Sincronizaciones Recientes",
        "time" => "Hora",
        "bridge" => "Puente",
        "response" => "Respuesta",
        "restaurant_created" => "Restaurante Creado",
        "restaurant_updated" => "Restaurante Actualizado",
        "hotel_created" => "Hotel Creado",
        "booking_created" => "Reserva Creada"
    ],
    'activity.php' => [
        "activity_log" => "Registro de Actividades",
        "activity_logs" => "Registros de Actividades",
        "activity_total_events" => "Eventos Totales",
        "activity_model_events" => "Cambios de Modelo",
        "activity_system_events" => "Eventos del Sistema",
        "activity_error_events" => "Errores",
        "activity_log_type" => "Tipo de Registro",
        "activity_event_type" => "Tipo de Evento",
        "activity_user_filter" => "Realizado Por",
        "activity_date_from" => "Fecha Desde",
        "activity_date_to" => "Fecha Hasta",
        "activity_clear_current_log" => "Borrar Registro Actual",
        "activity_clear_all_logs" => "Borrar Todos los Registros",
        "activity_breakdown_title" => "Desglose de Eventos",
        "activity_selected_title" => "Actividad Seleccionada",
        "activity_id" => "ID de Actividad",
        "activity_timestamp" => "Marca de Tiempo",
        "activity_causer" => "Activado Por",
        "activity_subject" => "Sujeto",
        "activity_description" => "Descripción",
        "activity_properties" => "Propiedades",
        "activity_summary" => "Resumen",
        "activity_no_description" => "No hay descripción disponible.",
        "system_generated" => "Sistema",
        "clear_selection" => "Borrar Selección",
        "per_page" => "Por Página",
        "unknown" => "Desconocido",
        "event_unknown" => "Desconocido",
        "all_activities" => "Todas las Actividades",
        "users_activity" => "Actividad de Usuarios",
        "system_activity" => "Actividad del Sistema",
        "event_created" => "Creado",
        "event_create" => "Creado",
        "event_updated" => "Actualizado",
        "event_update" => "Actualizado",
        "event_deleted" => "Eliminado",
        "event_delete" => "Eliminado",
        "event_restored" => "Restaurado",
        "event_restore" => "Restaurado",
        "event_error" => "Error",
        "event_failed" => "Fallido",
        "event_login" => "Inicio de Sesión",
        "event_logout" => "Cierre de Sesión",
        "event_register" => "Registro",
        "event_login_failed" => "Inicio de Sesión Fallido",
        "event_password_reset_request" => "Solicitud de Restablecimiento de Contraseña",
        "event_password_reset" => "Restablecimiento de Contraseña",
        "event_password_update" => "Actualización de Contraseña",
        "event_force_deleted" => "Eliminado Definitivamente",
        "testtest" => "prueba"
    ],
    'languages.php' => [
        "arabic" => "Árabe",
        "english" => "Inglés",
        "french" => "Francés",
        "français" => "Francés",
        "español" => "Español",
        "spanish" => "Español",
        "german" => "Alemán",
        "deutsch" => "Alemán",
        "italian" => "Italiano",
        "italiano" => "Italiano",
        "portuguese" => "Portugués",
        "russian" => "Ruso",
        "русский" => "Ruso",
        "pусский" => "Ruso",
        "chinese" => "Chino",
        "japanese" => "Japonés",
        "korean" => "Coreano",
        "turkish" => "Turco",
        "dutch" => "Holandés",
        "hebrew" => "Hebreo",
        "hindi" => "Hindi",
        "urdu" => "Urdu",
        "persian" => "Persa",
        "thai" => "Tailandés",
        "vietnamese" => "Vietnamita",
        "indonesian" => "Indonesio",
        "malay" => "Malayo",
        "swahili" => "Suajili",
        "greek" => "Griego",
        "polish" => "Polaco",
        "czech" => "Checo",
        "hungarian" => "Húngaro",
        "romanian" => "Rumano",
        "bulgarian" => "Búlgaro",
        "croatian" => "Croata",
        "serbian" => "Serbio",
        "ukrainian" => "Ucraniano",
        "finnish" => "Finlandés",
        "swedish" => "Sueco",
        "norwegian" => "Noruego",
        "danish" => "Danés"
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
    echo "-> $filename: Updated with translated Spanish values.\n";
}

echo "=====================================\n";
echo "SUCCESS! Applied Part 5 ($count keys) for Spanish.\n";
echo "=====================================\n";

?>
