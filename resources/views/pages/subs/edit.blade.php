@if ($user->menus[$s_menu]['subs'][$s_submenu]['can']['update'])
<!-- Edit Drawer -->
<div id="drawer-update-default" class="fixed top-0 right-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
    <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Update Menu</h5>
    <button type="button" data-drawer-dismiss="drawer-update-default" aria-controls="drawer-update-default" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">Close menu</span>
    </button>
    <form action="{{ route('sbmn.update') }}" method="post">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="e-for" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-600">*</span> For</label>
                <select name="for" id="e-for" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('for') }}" required="">
                    <option value="">Select Menu</option>
                    @foreach ($records['menus'] as $menu)
                        <option value="{{ md5($menu->mn_id) }}">{{ $menu->mn_detail }}</option>
                    @endforeach
                </select>
                @error('for')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="e-detail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-600">*</span> Detail</label>
                <input type="text" name="detail" id="e-detail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('detail') }}" placeholder="Sub Menu" required="">
                @error('detail')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="e-reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-600">*</span> Reference</label>
                <input type="text" name="reference" id="e-reference" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('reference') }}" placeholder="sub.index" required="">
                @error('reference')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="e-icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Icon
                    <span class="text-xs text-blue-500 hover:underline decoration-blue-500">[ <a href="https://fontawesome.com/v6/search?o=r&m=free" target="_blank">fontawesome</a> ]</span>
                </label>
                <input type="text" name="icon" id="e-icon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('icon') }}" placeholder="fa-circle">
                @error('icon')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="e-class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Class</label>
                <input type="text" name="class" id="e-class" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('class') }}" placeholder="bg-primary">
                @error('class')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="e-sequence" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sequence</label>
                <input type="number" name="sequence" id="e-sequence" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('sequence') }}" placeholder="0">
                @error('sequence')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
                <button type="submit" name="id" id="update" class="w-full justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Update
                </button>
                <button type="button" id="e-delete" data-drawer-target="drawer-delete-default" data-drawer-show="drawer-delete-default" aria-controls="drawer-delete-default" data-drawer-placement="right" class="w-full justify-center text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Delete
                </button>
            </div>
        </div>
    </form>
</div>
@endif
