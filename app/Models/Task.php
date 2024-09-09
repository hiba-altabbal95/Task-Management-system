<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;

    //Specify the table name of this model is user-task
    protected $table='user-task';

    protected $primaryKey='task_id';
    public $increment=true;


    protected $fillable = ['title', 'description', 'status', 'assigned_to', 'date_due', 'priority']; //Alternatively you can user  protected $guarded = ['id']; 

    public $timestamps = true; //Enable timestampes(Default)
   
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function user()
    {
       return $this->belongsTo(User::class, 'assigned_to');
    }

    // Accessor for date_due
    public function getDateDueAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    // Mutator for date_due
    public function setDateDueAttribute($value)
    {
        $this->attributes['date_due'] = Carbon::createFromFormat('d-m-Y H:i', $value);
    }

     // Scope for filtering by priority
     public function scopeByPriority($query, $priority)
     {
         return $query->where('priority', $priority);
     }
 
     // Scope for filtering by status
     public function scopeByStatus($query, $status)
     {
         return $query->where('status', $status);
     }
}
