<?php

namespace Fld3\PassportPgtServer\DataFactories;

use App\Models\User;
use Fligno\StarterKit\Abstracts\BaseDataFactory;
// Model
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserDataFactory
 *
 * @author James Carlo Luchavez <jamescarlo.luchavez@fligno.com>
 */
class UserDataFactory extends BaseDataFactory
{
    public string $name;

    public string $email;

    public string $password;

    /**
     * @param  string  $password
     */
    public function setPassword(string $password): void
    {
        $this->password = Hash::make($password);
    }

    /**
     * @return Builder
     *
     * @example User::query()
     */
    public function getBuilder(): Builder
    {
        return starterKit()->getUserQueryBuilder();
    }

    /**
     * @return string[]
     */
    public function getUniqueKeys(): array
    {
        return [
            'email',
        ];
    }
}
