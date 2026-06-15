<?php
// app/Models/Notification.php  (use Laravel's built-in or this custom one)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'message', 'type', 'read_at', 'report_id'];

    protected $casts = ['read_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Icon colour for the notification type.
     */
    public function getIconColorAttribute(): string
    {
        return match ($this->type) {
            'assigned'    => 'blue',
            'update'      => 'orange',
            'resolved'    => 'green',
            default       => 'blue',
        };
    }
}