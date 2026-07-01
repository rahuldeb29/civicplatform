<?php
// app/Models/Report.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'assigned_to',
        'title',
        'category',
        'priority',
        'description',
        'location',
        'latitude',
        'longitude',
        'image',
        'status',
    ];



    


    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function assignedOfficer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function photos()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function activities()
    {
        return $this->hasMany(ReportStatusLog::class);
    }



    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resolutionNote()
    {
        return $this->hasOne(ReportUpdate::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ReportStatusLog::class)->orderBy('created_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Submitted',
            'pending' => 'Pending',
            'assigned' => 'Assigned',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
            default => ucfirst($this->status),
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'in_progress' => 'progress',
            'assigned' => 'assigned',
            'resolved' => 'resolved',
            default => 'assigned',
        };
    }

    public function getPriorityClassAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'low',
            'medium' => 'medium',
            'high' => 'high',
            'critical' => 'critical',
            default => 'medium',
        };
    }


    public function getFormattedIdAttribute(): string
    {
        return '#CR-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}