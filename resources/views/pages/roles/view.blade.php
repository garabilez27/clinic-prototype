@extends('layouts.app')

@section('content')
<form action="{{ route('rl.menus.create') }}" method="post">
    @csrf
    <div class="px-4 pt-6">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Menus
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Sub Menus
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($records['menus'] as $menu)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="flex items-center mb-4">
                                            <input id="{{ md5($menu->mn_id) }}" type="checkbox" value="{{ md5($menu->mn_id) }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="menus[]" {{ in_array(md5($menu->mn_id), $records['role_menus']) ? 'checked' : '' }}>
                                            <label for="{{ md5($menu->mn_id) }}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $menu->mn_detail }}</label>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @foreach ($menu->subMenus as $sub)
                                        <div class="flex items-center mb-2">
                                            <input id="{{ md5($sub->sbmn_id) }}" type="checkbox" value="{{ md5($sub->sbmn_id).'-'.md5($menu->mn_id) }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="subs[]" {{ in_array(md5($sub->sbmn_id), $records['role_menus']) ? 'checked' : '' }}>
                                            <label for="{{ md5($sub->sbmn_id) }}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $sub->sbmn_detail }}</label>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        @if ($menu->mn_branched)
                                            @foreach ($menu->subMenus as $sub)
                                            <div>
                                                <div class="flex">
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="create" type="checkbox" value="{{ md5($sub->sbmn_id).'-create' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($sub->sbmn_id).'-create', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="create" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-plus"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="update" type="checkbox" value="{{ md5($sub->sbmn_id).'-update' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($sub->sbmn_id).'-update', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="update" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-edit"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="delete" type="checkbox" value="{{ md5($sub->sbmn_id).'-delete' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($sub->sbmn_id).'-delete', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="delete" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-trash"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="view" type="checkbox" value="{{ md5($sub->sbmn_id).'-view' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($sub->sbmn_id).'-view', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="view" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-eye"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @elseif ($menu->mn_has_actions)
                                            <div>
                                                <div class="flex">
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="create" type="checkbox" value="{{ md5($menu->mn_id).'-create' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($menu->mn_id).'-create', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="create" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-plus"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="update" type="checkbox" value="{{ md5($menu->mn_id).'-update' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($menu->mn_id).'-update', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="update" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-edit"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="delete" type="checkbox" value="{{ md5($menu->mn_id).'-delete' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($menu->mn_id).'-delete', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="delete" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-trash"></i>
                                                        </label>
                                                    </div>
                                                    <div class="flex items-center me-4 mb-2">
                                                        <input id="view" type="checkbox" value="{{ md5($menu->mn_id).'-view' }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" name="actions[]" {{ in_array(md5($menu->mn_id).'-view', $records['role_menus']) ? 'checked' : '' }}>
                                                        <label for="view" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            <i class="fa fa-eye"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="w-full flex items-center justify-center my-4">
                <button type="submit" name="id" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" value="{{ $records['id'] }}">Save Role Menus</button>
            </div>
        </div>
    </div>
</form>
@endsection
