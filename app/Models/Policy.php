<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends Model {
    use HasFactory;

    protected $fillable = ['client_id', 'document_type', 'document_name', 'file_path', 'file_size', 'mime_type', 'uploaded_by', 'is_verified', 'verified_by', 'verified_at'];
    protected $casts = ['is_verified' => 'boolean', 'verified_at' => 'datetime'];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function uploadedBy() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifiedBy() {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
