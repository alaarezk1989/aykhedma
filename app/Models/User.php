<?php

namespace App\Models;

use App\Constants\GenderTypes;
use App\Constants\UserTypes;
use App\Events\UserCreatedEvent;
use App\Events\UserDeletedEvent;
use App\Events\UserEditedEvent;
use App\Overrides\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use PhpParser\Node\Expr\Array_;

class User extends Authenticatable
{

    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;
    use CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable =[
        'first_name',
        'last_name',
        'password',
        'email',
        'phone',
        'birthdate',
        'gender',
        'active',
        'type',
        'vendor_id',
        'token',
        'class',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $value
     * @return mixed
     */
    public function getImageAttribute($value)
    {
        if (strpos($value, 'public/') !== false) {
            return str_replace("public/", "", $value);
        }

        return $value;
    }

    /**
     * @param $pass
     */
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = \Hash::make($pass);
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => 0,
        'gender' => GenderTypes::FEMALE,
        'type' => UserTypes::NORMAL
    ];

    public function getNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups', 'user_id', 'group_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class, 'user_id', 'id');
    }

    public function favoritedProducts()
    {
        return $this->belongsToMany(BranchProduct::class, "favorited_products")
            ->withTimestamps();
    }

    public $dispatchesEvents = [
        'created' => UserCreatedEvent::class,
        'updated' => UserEditedEvent::class,
        'deleted' => UserDeletedEvent::class,
    ];

    public function points()
    {
        return $this->hasMany(Point::class)->orderBy('id', 'DESC');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'id', 'vendor_id')->where('vendor_id', '!=', null);
    }

    /**
     * @param array|string $permission
     * @return bool
     */
    public function hasAccess($permission, $permissible = null): bool
    {
        $userPermissions = $this->permissions();

        if (!$permissible || !count($this->permissionsData(get_class($permissible)))) {
            return in_array($permission, $userPermissions);
        }
        if (count($permissible->permissible) && Permissible::where('user_id', auth()->user()->id )->where('permissible_id', $permissible->id)->where('permissible_type', get_class($permissible))->first()) {
            return in_array($permission, $userPermissions);
        }
        return false;
    }

    public function hasBranchAccess($branch): bool
    {
        $permissionsData = $this->permissionsData(get_class($branch));
        if (count($this->permissionsData(get_class($branch)))) {
            return in_array($branch->id, $permissionsData);
        }

        return true;
    }

    /**
     * @return array
     */
    public function permissions() : array
    {
        $permissions = $this->query()
            ->join("user_groups", "users.id", "=", "user_groups.user_id")
            ->join("groups", "user_groups.group_id", "=", "groups.id")
            ->join("group_permissions", "groups.id", "=", "group_permissions.group_id")
            ->join("permissions", "group_permissions.permission_id", "=", "permissions.id")
            ->select("permissions.identifier")
            ->where("users.id", "=", auth()->id())
            ->distinct()
            ->get();

        $permissionsIdentifier = [];
        foreach ($permissions as $permission) {
            $permissionsIdentifier[] = $permission["identifier"];
        }

        return $permissionsIdentifier;
    }

    public function permissionsData($modelType) : array
    {
        $permissions = $this->query()
            ->join("user_permissible", "users.id", "=", "user_permissible.user_id")
            ->select("user_permissible.permissible_id")
            ->where("users.id", "=", auth()->id())
            ->where("user_permissible.permissible_type", "=", $modelType)
            ->distinct()
            ->get();

        $permissionsIdsArray = [];
        foreach ($permissions as $permission) {
            $permissionsIdsArray[] = $permission["permissible_id"];
        }

        return $permissionsIdsArray;
    }

    public function isTypeOf($userType)
    {
        return ($this->type == $userType);
    }

    public function Company()
    {
        return $this->belongsTo(Company::class) ;
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'driver_orders', 'driver_id', 'order_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'accountable');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_use', 'user_id', 'coupon_id');
    }

    public function revenues()
    {
        return $this->morphMany(Revenue::class, 'accountable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function branchesPermission()
    {
        return $this->hasMany(Permissible::class)->where('permissible_type', 'App\Models\Branch');
    }

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('phone', $identifier)->first();
    }

    public function publicDriverBranches()
    {
        return $this->belongsToMany(Branch::class, "public_driver_branches",'user_id', 'branch_id')->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
