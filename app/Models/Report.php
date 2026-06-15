<?php
// app/Models/Report.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'title',
        'description',
        'address',
        'status',       // submitted | pending | assigned | in_progress | resolved | closed
        'priority',     // low | medium | high | critical
        'latitude',
        'longitude',
    ];

    // ── Relationships ──────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ReportStatusLog::class)->orderBy('created_at');
    }

    // ── Accessors ──────────────────────────────────────────────────

    /**
     * Human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted'   => 'Submitted',
            'pending'     => 'Pending',
            'assigned'    => 'Assigned',
            'in_progress' => 'In Progress',
            'resolved'    => 'Resolved',
            'closed'      => 'Closed',
            default       => ucfirst($this->status),
        };
    }

    /**
     * CSS class suffix for status badge.
     */
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'in_progress' => 'progress',
            'assigned'    => 'assigned',
            'resolved'    => 'resolved',
            default       => 'assigned',
        };
    }

    /**
     * CSS class suffix for priority badge.
     */
    public function getPriorityClassAttribute(): string
    {
        return match ($this->priority) {
            'low'      => 'low',
            'medium'   => 'medium',
            'high'     => 'high',
            'critical' => 'critical',
            default    => 'medium',
        };
    }

    /**
     * Formatted report ID like #CR-9012.
     */
    public function getFormattedIdAttribute(): string
    {
        return '#CR-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}