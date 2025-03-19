<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profile;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)
            ->orWhere('mobile', $identifier)
            ->first();
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];
    // protected $with = ['profile'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Get the profile associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public function sendVerifyCode($code, $mobile)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false // Disable SSL certificate verification
        ]);

        $headers = [
            'apikey' => 'OWU1ZTVkNmYtZWQ3Ny00YTQwLTg4MTctYTRkNzhjZjhkMjUzMThlOTUxYTU0Y2EwOWZmZDBlMWU4M2Y2YjcwMmMxNzE=',
            'accept' => '*/*',
            'Content-Type' => 'application/json',
        ];

        $body = '{
            "code": "zdpp7kyvuuh0bvt",
            "sender": "+983000505",
            "recipient": "' . $mobile . '",
            "variable": {
                "order_id": "' . $code . '",
                "table_id": "1"
            }
        }';

        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://api2.ippanel.com/api/v1/sms/pattern/normal/send', $headers, $body);
        $response = $client->sendAsync($request)->wait();

        echo $response->getBody();
    }
}
