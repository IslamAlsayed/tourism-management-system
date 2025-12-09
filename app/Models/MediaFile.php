<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\FiltersByUserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaFile extends Model
{
    use HasFactory, HasSearch, HasRichText, SoftDeletes, FiltersByUserRole;

    protected $richTextAttributes = [
        'description',
    ];

    protected $fillable = [
        'id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'disk',
        'collection_name',
        'model_type',
        'model_id',
        'width',
        'height',
        'alt_text',
        'description',
        'title',
        'metadata',
        'is_featured',
        'is_active',
        'order',
        'uploaded_by',
        'uploaded_at',
        'table_columns',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return ['metadata', 'table_columns', 'deleted_at'];
    }

    /**
     * Get the owning model (polymorphic relation)
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who uploaded the file
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL of the file
     */
    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }

    /**
     * Get human readable file size
     */
    public function getHumanFileSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Get file extension
     */
    public function getExtensionAttribute()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is an image
     */
    public function getIsImageAttribute()
    {
        return $this->file_type === 'image' || in_array($this->mime_type, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
        ]);
    }

    /**
     * Check if file exists
     */
    public function exists()
    {
        return Storage::disk($this->disk)->exists($this->file_path);
    }

    /**
     * Delete file from storage
     */
    public function deleteFile()
    {
        if ($this->exists()) {
            return Storage::disk($this->disk)->delete($this->file_path);
        }
        return false;
    }

    /**
     * Scope: only images
     */
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    /**
     * Scope: by collection
     */
    public function scopeInCollection($query, $collection)
    {
        return $query->where('collection_name', $collection);
    }

    /**
     * Scope: orphaned files (no model relation)
     */
    public function scopeOrphaned($query)
    {
        return $query->whereNull('model_type')->whereNull('model_id');
    }

    public static function getAvailableCollection()
    {
        $unsetKeys = ['cache', 'cache_locks', 'failed_jobs', 'job_batches', 'jobs', 'migrations', 'password_reset_tokens', 'rich_texts', 'sessions', 'sidebar_menu_orders'];
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $tableNames = array_diff($tableNames, $unsetKeys);
        $tableNames = array_merge($tableNames, ['general']);
        return $tableNames;
    }
}