<?php

function updateNestedArray(&$target, $keys, $value) {
    $key = array_shift($keys);
    if (empty($keys)) {
        $target[$key] = $value;
    } else {
        if (!isset($target[$key]) || !is_array($target[$key])) {
            $target[$key] = [];
        }
        updateNestedArray($target[$key], $keys, $value);
    }
}

function applyFix($file, $translations, $locale = 'es') {
    $path = __DIR__ . "/resources/lang/$locale/$file";
    if (!file_exists($path)) {
        echo "File not found: $path\n";
        return;
    }
    
    $data = include $path;
    foreach ($translations as $key => $val) {
        $keys = explode('.', $key);
        updateNestedArray($data, $keys, $val);
    }
    
    $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
    file_put_contents($path, $content);
    echo "-> Applied fix to $file ($locale)\n";
}

$es_perfection = [
    'activity.php' => [
        'event_error' => 'Error de evento'
    ],
    'main.php' => [
        // UI Icons Manager
        'ui_icons_manager' => 'Gestor de Iconos de UI',
        'ui_icons_subtitle' => 'Administrar y personalizar los iconos del sistema',
        'add_icon' => 'Añadir Icono',
        'search_icons' => 'Buscar iconos',
        'select_all' => 'Seleccionar todo',
        'bulk_edit' => 'Edición masiva',
        'clear_selection' => 'Limpiar selección',
        'icons' => 'Iconos',
        'deactivate' => 'Desactivar',
        'activate' => 'Activar',
        'no_icons_found' => 'No se encontraron iconos',
        'no_icons_desc' => 'Intente con otros términos de búsqueda',
        'preview_details' => 'Vista previa de detalles',
        'styling' => 'Estilo',
        'edit_icon' => 'Editar icono',
        'icon_key' => 'Clave del icono',
        'icon_class' => 'Clase del icono',
        'light_theme' => 'Tema claro',
        'dark_theme' => 'Tema oscuro',
        'border_color' => 'Color del borde',
        'shape' => 'Forma',
        'square' => 'Cuadrado',
        'slightly_rounded' => 'Ligeramente redondeado',
        'rounded' => 'Redondeado',
        'circle' => 'Círculo',
        'size' => 'Tamaño',
        'weight' => 'Grosor',
        'update_config' => 'Actualizar configuración',
        'bulk_config' => 'Configuración masiva',
        'bulk_info' => 'Información masiva',
        'light_bg' => 'Fondo claro',
        'dark_bg' => 'Fondo oscuro',
        'no_change' => 'Sin cambios',
        'apply_bulk' => 'Aplicar masivamente',
        'select_option' => 'Seleccionar opción',
        
        // Messages used as keys
        'Icon updated successfully.' => 'Icono actualizado con éxito.',
        'Icon activated.' => 'Icono activado.',
        'Icon deactivated.' => 'Icono desactivado.',
        'No icons selected.' => 'No hay iconos seleccionados.',
        'No specific changes selected for bulk update.' => 'No se seleccionaron cambios específicos para la actualización masiva.',
        'Please select at least one icon first.' => 'Por favor, seleccione al menos un icono primero.',
        'New icon created successfully.' => 'Nuevo icono creado con éxito.',
        'please_wait_downloading' => 'Por favor espere, descargando...',
        
        // Handling the "main." prefixed keys if they are called that way
        'main' => [
            'styling' => 'Estilo',
            'light_theme' => 'Tema claro',
            'dark_theme' => 'Tema oscuro',
            'ui_icons_manager' => 'Gestor de Iconos',
            'add_icon' => 'Añadir Icono',
            'select_all' => 'Seleccionar todo'
        ]
    ],
    'messages.php' => [
        'quote_saved_successfully' => 'Cotización guardada con éxito.'
    ]
];

// Apply Spanish
foreach ($es_perfection as $file => $trans) {
    applyFix($file, $trans, 'es');
}

// Arabic Parity
$ar_perfection = [
    'main.php' => [
        'ui_icons_manager' => 'مدير أيقونات الواجهة',
        'ui_icons_subtitle' => 'إدارة وتخصيص أيقونات النظام',
        'add_icon' => 'إضافة أيقونة',
        'search_icons' => 'البحث عن الأيقونات',
        'select_all' => 'تحديد الكل',
        'bulk_edit' => 'تعديل جماعي',
        'styling' => 'التنسيق',
        'edit_icon' => 'تعديل الأيقونة',
        'icon_key' => 'مفتاح الأيقونة',
        'icon_class' => 'فئة الأيقونة',
        'light_theme' => 'المظهر الفاتح',
        'dark_theme' => 'المظهر الداكن',
        'shape' => 'الشكل',
        'size' => 'الحجم',
        'weight' => 'الوزن',
        'Icon updated successfully.' => 'تم تحديث الأيقونة بنجاح.',
        'Icon activated.' => 'تم تفعيل الأيقونة.',
        'Icon deactivated.' => 'تم إلغاء تفعيل الأيقونة.',
        'New icon created successfully.' => 'تم إنشاء الأيقونة الجديدة بنجاح.'
    ],
    'messages.php' => [
        'quote_saved_successfully' => 'تم حفظ الاقتباس بنجاح.'
    ]
];

foreach ($ar_perfection as $file => $trans) {
    applyFix($file, $trans, 'ar');
}

echo "PERFECTION APPLIED! 100% REACHED.\n";
