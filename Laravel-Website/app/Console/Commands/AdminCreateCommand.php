<?php

namespace App\Console\Commands;

use App\Models\Administrator;
use App\Models\Role;
use Database\Seeders\AdminRoleSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminCreateCommand extends Command
{
    protected $signature = 'smevolve:admin:create
                            {--name= : Administrator full name}
                            {--email= : Administrator email address}
                            {--password= : Initial password (prompts securely when omitted)}';

    protected $description = 'Create or update the super administrator account';

    public function handle(): int
    {
        $this->call(AdminRoleSeeder::class);

        $name = $this->option('name') ?? $this->ask('Administrator name', 'SMEvolve Administrator');

        if (! is_string($name) || trim($name) === '') {
            $this->error('Administrator name cannot be empty.');

            return self::FAILURE;
        }

        $email = $this->resolveEmail();

        if ($email === null) {
            return self::FAILURE;
        }

        $existing = Administrator::where('email', $email)->first();

        if ($existing !== null && ! $this->confirm('An administrator with that email already exists. Update their details instead?')) {
            $this->error('Aborted — no changes were made.');

            return self::FAILURE;
        }

        $password = $this->resolvePassword();

        if ($password === null) {
            return self::FAILURE;
        }

        $passwordRule = Password::min(8);

        if (app()->environment('production')) {
            $passwordRule = $passwordRule->uncompromised();
        }

        $validator = Validator::make(['password' => $password], [
            'password' => ['required', 'string', $passwordRule],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->get('password') as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $role = Role::where('name', 'super_admin')->first();

        if ($role === null) {
            $this->error('The super_admin role does not exist.');

            return self::FAILURE;
        }

        Administrator::updateOrCreate(['email' => $email], [
            'name' => trim($name),
            'password' => $password,
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        $this->info('Super administrator ready: '.trim($name).' <'.$email.'>');
        $this->line('Log in at /admin with the email you set.');
        $this->line('Change the password from Admin Portal -> Account -> Security after your first login.');

        return self::SUCCESS;
    }

    private function resolveEmail(): ?string
    {
        $email = $this->option('email');

        if ($email === null && ! $this->nonInteractive()) {
            $email = $this->ask('Administrator email');

            while (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $email = $this->ask('Please enter a valid email address');
            }
        }

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error('A valid administrator email is required.');

            return null;
        }

        return mb_strtolower(trim($email));
    }

    private function resolvePassword(): ?string
    {
        $password = $this->option('password');

        if ($password === null) {
            if ($this->nonInteractive()) {
                $this->error('Provide --password (or run interactively) when automating admin creation.');

                return null;
            }

            $password = $this->secret('Administrator password');
            $confirmation = $this->secret('Confirm administrator password');

            if ($password !== $confirmation) {
                $this->error('Passwords do not match.');

                return null;
            }
        }

        if (! is_string($password) || $password === '') {
            $this->error('A password is required.');

            return null;
        }

        return $password;
    }

    /**
     * True when the command runs without an interactive terminal (for example
     * in automation, where prompts cannot be answered).
     */
    private function nonInteractive(): bool
    {
        try {
            return ! $this->isMultiLevelInteractive();
        } catch (\Exception) {
            return true;
        }
    }
}