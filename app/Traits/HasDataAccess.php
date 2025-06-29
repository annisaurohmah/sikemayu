<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasDataAccess
{
    /**
     * Get data access configuration for current user
     */
    public function getDataAccess()
    {
        $user = Auth::user();
        
        return [
            'role' => $user->role,
            'rw' => $user->no_rw,
            'posyandu' => $user->nama_posyandu,
            'can_access_all' => $user->role === 'admin_desa',
            'can_access_rw_only' => $user->role === 'admin_rw' && !empty($user->no_rw) && empty($user->nama_posyandu),
            'can_access_posyandu_only' => $user->role === 'admin_kader' && !empty($user->nama_posyandu)
        ];
    }

    /**
     * Apply data filter based on user access level
     */
    public function applyDataFilter($query, $table = null)
    {
        $access = $this->getDataAccess();
        
        // Admin can access all data
        if ($access['can_access_all']) {
            return $query;
        }
        
        // Kader RW - only access their RW data
        if ($access['can_access_rw_only']) {
            if ($table === 'dasawisma' || $table === 'dw') {
                return $query->whereHas('rw', function($q) use ($access) {
                    $q->where('no_rw', $access['rw']);
                });
            } elseif ($table === 'rw') {
                return $query->where('no_rw', $access['rw']);
            }
        }
        
        // Kader Posyandu - only access their posyandu data
        if ($access['can_access_posyandu_only']) {
            if (in_array($table, ['sip', 'posyandu_data'])) {
                return $query->whereHas('posyandu', function($q) use ($access) {
                    $q->where('nama_posyandu', $access['posyandu']);
                });
            } elseif ($table === 'posyandu') {
                return $query->where('nama_posyandu', $access['posyandu']);
            }
        }
        
        return $query;
    }

    /**
     * Check if user can access specific data
     */
    public function canAccessData($dataType, $identifier = null)
    {
        $access = $this->getDataAccess();
        
        // Admin can access everything
        if ($access['can_access_all']) {
            return true;
        }
        
        switch ($dataType) {
            case 'dasawisma':
                return $access['can_access_rw_only'] && 
                       ($identifier === null || $identifier === $access['rw']);
                       
            case 'posyandu':
                return $access['can_access_posyandu_only'] && 
                       ($identifier === null || $identifier === $access['posyandu']);
                       
            case 'sip':
                return $access['can_access_posyandu_only'];
                
            default:
                return false;
        }
    }
}
