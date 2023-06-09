<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Orchid\Layouts\Role\RoleEditLayout;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class RoleEditScreen extends Screen
{
    /**
     * @var Role
     */
    public $role;

    /**
     * Query data.
     *
     * @param Role $role
     *
     * @return array
     */
    public function query(Role $role): array
    {
        return [
            'role'       => $role,
            'permission' => $role->getStatusPermission(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Manage roles';
    }

    /**
     * Display header description.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Access rights';
    }

    /**
     * @return iterable
     */
    public function permission(): iterable
    {
        return [
            'platform.systems.roles',
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->role->exists),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::block([
                RoleEditLayout::class,
            ])
                ->title('Role')
                ->description('A role is a collection of privileges (of possibly different services like the Users service, Moderator, and so on) that grants users with that role the ability to perform certain tasks or operations.'),

            Layout::block([
                RolePermissionLayout::class,
            ])
                ->title('Permission/Privilege')
                ->description('A privilege is necessary to perform certain tasks and operations in an area.'),
        ];
    }

    /**
     * @param Request $request
     * @param Role    $role
     * @return RedirectResponse
     */
    public function save(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'role.slug' => [
                'required',
                Rule::unique(Role::class, 'slug')->ignore($role),
            ],
        ]);

        $role->fill($request->get('role'));

        $role->permissions = collect($request->get('permissions'))
            ->map(function ($value, $key) {
                return [base64_decode($key) => $value];
            })
            ->collapse()
            ->toArray();

        $role->save();

        Toast::info(__('Role was saved'));

        return redirect()->route('platform.systems.roles');
    }

    /**
     * @param Role $role
     * @throws Exception
     * @return RedirectResponse
     */
    public function remove(Role $role): RedirectResponse
    {
        $role->delete();

        Toast::info(__('Role was removed'));

        return redirect()->route('platform.systems.roles');
    }
}
