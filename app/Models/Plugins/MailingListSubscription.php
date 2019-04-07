<?php

namespace App\Models\Plugins;

use Illuminate\Database\Eloquent\Model;

class MailingListSubscription extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'plugins_mailing_list_subscriptions';

    /**
     * Disable mass assignment exception.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Cast attributes to non-string PHP types.
     *
     * @var array
     */
    protected $casts = [
        'attrs' => 'array'
    ];
}
