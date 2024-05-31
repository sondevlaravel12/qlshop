<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Webinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $tenant;
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function(){
            $admin = User::create([
                'name'=>$this->tenant->id,
                'email'=>'admin_'. $this->tenant->id .'@gmail.com',
                'password'=> Hash::make('12345678')
            ]);
            $superAdmin = User::create([
                'name'=>$this->tenant->id,
                'email'=>'superadmin@gmail.com',
                'password'=> Hash::make('12345678')
            ]);
            //role
            $spARole = Role::create(['name'=>'superadmin']);
            $adminRole = Role::create(['name'=>'admin']);
            $modifierRole = Role::create(['name'=>'modifier']);
            //permission
            $SPAPermission = Permission::create(['name'=>'SPA permission']);
            $articlePermission = Permission::create(['name'=>'articles permission']);
            $orderPermission = Permission::create(['name'=>'orders permission']);
            $productPermission = Permission::create(['name'=>'inventory product permission']);
            // assign permissions to Roles
            // $permission->assignRole($role);
            $SPAPermission->assignRole($spARole);
            $orderPermission->assignRole($adminRole);
            $productPermission->assignRole($adminRole);
            $articlePermission->assignRole($adminRole);
            $articlePermission->assignRole($modifierRole);
            // assign Roles to Users
            // $user->assignRole('writer');
            $admin->assignRole($adminRole);
            $superAdmin->assignRole($spARole);

            // tenant information
            Webinfo::create([
                'name' => 'cty abc',
                'phonebase' => '111111111',
                'address' => '123 duong 3.2, tp hcm',
            ]);
            Webinfo::first()->addMediaFromUrl('https://hatgionglamson.com/asset/upload/image/logotuychinh.png?v=20190410')->toMediaCollection('logo');
            // $table->string('name')->nullable();
            // $table->string('title')->nullable();
            // $table->string('keyword')->nullable();
            // $table->string('description')->nullable();
            // $table->string('logo')->nullable();
            // $table->string('icon')->nullable();
            // $table->longText('google_map')->nullable();
            // $table->string('email')->nullable();
            // $table->string('email2')->nullable();
            // $table->string('phone')->nullable();
            // $table->string('phone2')->nullable();
            // $table->text('phonebase')->nullable();
            // $table->string('address')->nullable();
            // $table->string('address_2')->nullable();
            // $table->string('zalo_url')->nullable();
            // $table->string('facebook_url')->nullable();
        return "done";

        });
    }
}
