<?php

declare(strict_types=1);

namespace Tipoff\EscapeRoom\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\EscapeRoom\Models\EscaperoomTheme;
use Tipoff\Support\Contracts\Models\UserInterface;

class EscaperoomThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view themes') ? true : false;
    }

    public function view(UserInterface $user, EscaperoomTheme $theme): bool
    {
        return $user->hasPermissionTo('view themes') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create themes') ? true : false;
    }

    public function update(UserInterface $user, EscaperoomTheme $theme): bool
    {
        return $user->hasPermissionTo('update themes') ? true : false;
    }

    public function delete(UserInterface $user, EscaperoomTheme $theme): bool
    {
        return false;
    }

    public function restore(UserInterface $user, EscaperoomTheme $theme): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, EscaperoomTheme $theme): bool
    {
        return false;
    }
}
