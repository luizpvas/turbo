<?php

namespace App\Models\Plugins;

use App\Models\Traits\WebsiteScoped;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    use WebsiteScoped, SoftDeletes;

    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'plugins_mailing_lists';

    /**
     * Disable mass assignment exceptions.
     *
     * @var array
     */
    protected $guarded = [];

    static function boot()
    {
        parent::boot();

        self::creating(function ($mailingList) {
            $mailingList->subscribed_success_template = '
                <h1>Thanks for registering!</h1>
                <div>You\'ll receive an email sometime in the future</div>
            ';

            $mailingList->already_subscribed_template = '
                <h1>Oops, it looks like you\'re already subscribed.</h1>
                <div>Thanks for being interested again!</div>
            ';
        });
    }

    function subscriptions()
    {
        return $this->hasMany(MailingListSubscription::class);
    }
}
