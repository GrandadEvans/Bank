<?php

namespace Bank\UtilityClasses;

use Illuminate\Support\Facades\Auth;

class RegularTransactionUtilities
{

    /**
     * Get the directory for the scan files for this particular user
     *
     * @return string
     */
    public static function getRegularScanDirectory(): string
    {
        return resource_path().'/newRegularScans/'.'user_'.Auth::id().'/';
    }
}
