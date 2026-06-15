<?php
// app/Models/ReportStatusLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatusLog extends Model
{
    protected $fillable = ['report_id', 'status', 'note', 'created_by'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}