<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
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



        return "done";

        });
    }
}
