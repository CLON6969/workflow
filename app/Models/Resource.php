<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Resource extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'mime_type',
        'size',
        'version',
        'status',
        'content_hash',
        'uploader_id',

        'exam_board_id',
        'board_year_id',
        'board_session_id',
        'board_program_id',
        'board_course_id',

        'exam_session',
        'paper_number',
        'year',
        'semester',
        'is_practical',

        'parent_resource_id',
        'downloads_count',
        'views_count',
    ];

    protected $casts = [
        'is_practical' => 'boolean',
    ];

    // ================= RELATIONSHIPS =================

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function examBoard()
    {
        return $this->belongsTo(ExamBoard::class);
    }

    public function boardYear()
    {
        return $this->belongsTo(BoardYear::class);
    }

    public function boardSession()
    {
        return $this->belongsTo(BoardSession::class);
    }

    public function boardProgram()
    {
        return $this->belongsTo(BoardProgram::class);
    }

    public function boardCourse()
    {
        return $this->belongsTo(BoardCourse::class);
    }

    // ================= VERSIONING =================

    public function parentResource()
    {
        return $this->belongsTo(Resource::class, 'parent_resource_id');
    }

    public function versions()
    {
        return $this->hasMany(Resource::class, 'parent_resource_id');
    }

    // ================= EXTRA =================

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ================= SCOPES =================

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePastPapers($query)
    {
        return $query->where('type', 'past_paper');
    }

    public function scopeForCourse($query, $courseId)
    {
        return $query->where('board_course_id', $courseId);
    }
}
