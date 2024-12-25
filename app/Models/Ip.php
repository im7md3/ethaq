<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Location\Facades\Location;

class Ip extends Model
{
    use HasFactory;
    protected $fillable = ['ip', 'country', 'device', 'type'];
    public static function store($request, $type = null)
    {
        $Info = Location::get();
        $ip=$request->ip();
        $old_ip = Self::where('ip', $ip)->count();
        if ($old_ip == 0) {
            $agent = $request->header('User-Agent');
            $device='';
            if (strpos($agent, 'Windows') !== false) {
                $device = "laptop";
            } elseif (strpos($agent, 'Mac') !== false) {
                $device = "laptop";
            } elseif (strpos($agent, 'Linux') !== false) {
                $device = "laptop";
            } elseif (strpos($agent, 'iphone') !== false) {
                $device = "mobile";
            } elseif (strpos($agent, 'Android') !== false) {
                $device = "mobile";
            } elseif (strpos($agent, 'ipod') !== false) {
                $device = "mobile";
            }
            $country = $Info->countryName;
            static::query()->create(compact('ip', 'device', 'country','type'));
        }
    }
}
