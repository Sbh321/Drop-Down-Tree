<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use YajTech\Crud\Traits\CrudEventListener;
use YajTech\Crud\Traits\CrudModel;

class Linux extends Model
{
    use HasFactory, CrudModel, SoftDeletes, CrudEventListener;

    const COLUMNS = [
        [
            'name' => 'sn',
            'label' => 'SN',
            'align' => 'left',
            'type' => 'text',
            'sortable' => true,
        ],
        [
            'name' => 'name',
            'label' => 'Name',
            'align' => 'left',
            'type' => 'text',
            'sortable' => true,
        ],
        [
            'name' => 'parent_id',
            'label' => 'Parent_id',
            'align' => 'left',
            'type' => 'text',
            'sortable' => true,
        ],
    ]
    ;
    const FIELDS = [
        [
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-6',
            ],
            'rules' => [
                'required' => true,
            ],
        ],
        [
            'name' => 'parent_id',
            'label' => 'Parent_id',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-6',
            ],
            'rules' => [
                'required' => true,
            ],
        ],
    ]
    ;
    const TABLE = [
        'add_button' => true,
        'refresh_button' => true,
        'export_button' => true,
        'filter_button' => true,
    ];
    const FILTERS = [
        [
            'name' => 'name',
            'columns' => 'name',
            'type' => 'text',
            'relation' => 'where',
            'dense' => true,
            'label' => 'Name',
            'wrapper' => [
                'class' => 'col-3',
            ],
        ],
        [
            'name' => 'parent_id',
            'columns' => 'parent_id',
            'type' => 'text',
            'relation' => 'where',
            'dense' => true,
            'label' => 'Parent_id',
            'wrapper' => [
                'class' => 'col-3',
            ],
        ],
    ]
    ;

    protected $fillable = ['name', 'parent_id', 'created_by', 'updated_by', 'extra'];

    protected $casts = [
        'extra' => 'array',
    ];

    public function getIndexCollectionOld()
    {
        return Linux::orderBy('created_at', 'asc')->get();
    }
}
