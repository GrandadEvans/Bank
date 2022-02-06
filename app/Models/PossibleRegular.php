<?php

namespace Bank\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PossibleRegular extends Model
{
    use HasFactory;

    public const IGNORED = 'ignored';

    public const CREATED = 'created';

    public const DECLINED = 'declined';

    public const POSTPONED = 'postponed';

    /**
     * Created an easy to use outstanding scope
     *
     * This will return a collection of all the outstanding regular suggestions
     * that the user currently has. This is much simpler than implementing the
     * individual requests here and there
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOutstanding(Builder $query):Builder
    {
        return $query->
            where('user_id', Auth::id())->
            whereIn('last_action', [self::POSTPONED, self::CREATED]);
    }

    public function markAccepted(int $id): bool
    {
        $pr = $this->find($id);
        $pr->last_action = 'accepted';
        $pr->last_action_happened = now();

        if ($pr->save()) {
            return true;
        }
        return false;
    }
}
