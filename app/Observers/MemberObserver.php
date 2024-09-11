<?php

namespace App\Observers;

use App\Models\Member;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function created(Member $member)
    {
        //
    }

    /**
     * Handle the Member "updated" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function updated(Member $member)
    {
        //
    }

    /**
     * Handle the Member "deleted" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function deleting(Member $member)
    {
        if ($member->image) {
            $member->image->delete();
        }

        if ($member->signature) {
            $member->signature->delete();
        }
    }

    /**
     * Handle the Member "restored" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function restored(Member $member)
    {
        //
    }

    /**
     * Handle the Member "force deleted" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function forceDeleted(Member $member)
    {
        //
    }
}
