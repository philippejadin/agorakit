<div class="py-3 border-gray-300 border-b flex @if ($file->isArchived()) status-archived @endif  @if ($file->isPinned()) status-pinned @endif"
    up-expand>

    <div>
        @if ($file->isPinned())
                    <div class="text-xs absolute w-5 h-5 rounded-full text-white bg-red-700 flex items-center justify-center border-white border-2 shadow-md ">
                        <i class="fas fa-thumbtack" title="{{__('Pinned')}}"></i>
                    </div>
        @endif
        
        @if ($file->isLink())
        <a class="mr-4 flex-shrink-0" href="{{ route('groups.files.download', [$file->group, $file]) }}" target="_blank">
            <img class="rounded w-12 h-12" src="{{ route('groups.files.thumbnail', [$file->group, $file]) }}" />
        </a>
        @elseif ($file->isFolder())
        <a up-follow class="mr-4 flex-shrink-0" href="{{ route('groups.files.index', ['group' => $file->group, 'parent' => $file]) }}">
            <img class="rounded w-12 h-12" src="{{ route('groups.files.thumbnail', [$file->group, $file]) }}" />
        </a>
        @else
        <a up-follow  class="mr-4 flex-shrink-0" up-follow href="{{ route('groups.files.show', [$file->group, $file]) }}">
            <img class="rounded w-12 h-12" src="{{ route('groups.files.thumbnail', [$file->group, $file]) }}" />
        </a>
        @endif
    </div>


    <div class="w-100 flex-grow">
        <div class="text-lg">
            @if ($file->isFolder())
                <a up-follow href="{{ route('groups.files.index', ['group' => $file->group, 'parent' => $file]) }}">
            @else
                <a up-follow href="{{ route('groups.files.show', [$file->group, $file]) }}">
            @endif
                {{ $file->name }}
            </a>
        </div>


       




        <div class="text-xs text-gray-500 flex space-x-2 hover:text-gray-600">
           
                @if ($file->isPinned())
                <div class="badge badge-primary" style="min-width: 2em; margin: 0 2px;">
                    <i class="fas fa-thumbtack"></i>
                    {{__('Pinned')}}
                </div>
                @endif
                @if ($file->isArchived())
                <div class="badge badge-secondary" style="min-width: 2em; margin: 0 2px;">
                    <i class="fa fa-archive"></i>
                    {{__('Archived')}}
                </div>
                @endif
           
            <div>
                
                    @if ($file->group->isOpen())
                    <i class="fa fa-globe" title="{{trans('group.open')}}"></i>
                    @elseif ($file->group->isClosed())
                    <i class="fa fa-lock" title="{{trans('group.closed')}}"></i>
                    @else
                    <i class="fa fa-eye-slash" title="{{trans('group.secret')}}"></i>
                    @endif
                    {{ $file->group->name }}
                
            </div>

            <div>
                
                    <i class="fa fa-user-circle"></i> {{ $file->user->name }}
                
            </div>

            <div>
                <i class="fa fa-clock-o"></i> {{ $file->updated_at }}
            </div>

            <div>
                @if ($file->isFile())
                <i class="fa fa-database"></i> {{sizeForHumans($file->filesize)}}
                @endif
            </div>
            <div>
                @if ($file->isLink())
                <i class="fas fa-link"></i> {{$file->path}}
                @endif
            </div>

            @if ($file->getSelectedTags()->count() > 0)
            <div class="">
            <i class="fa fa-tags"></i>
            @foreach ($file->getSelectedTags() as $tag)
            @include('tags.tag')
            @endforeach
            </div>
            @endif

        </div>

        

    </div>

    @can('update', $file)
    <div class="ml-auto dropdown">
        <a class="rounded-full hover:bg-gray-400 w-10 h-10 flex items-center justify-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

            @can('update', $file)
            <a class="dropdown-item" href="{{ route('groups.files.edit', [$file->group, $file]) }}">
                <i class="fa fa-pencil"></i>
                {{trans('messages.edit')}}
            </a>
            @endcan

            @can('delete', $file)
            <a class="dropdown-item" href="{{ route('groups.files.deleteconfirm', [$file->group, $file]) }}">
                <i class="fa fa-trash"></i>
                {{trans('messages.delete')}}
            </a>
            @endcan

            @can('pin', $file)
            <a up-follow up-cache="false" up-restore-scroll="true" class="dropdown-item"
                href="{{ route('groups.files.pin', [$file->group, $file]) }}">
                <i class="fa fa-thumbtack"></i>
                @if($file->isPinned())
                {{trans('messages.unpin')}}
                @else
                {{trans('messages.pin')}}
                @endif
            </a>
            @endcan

            @can('archive', $file)
            <a up-follow up-cache="false" up-restore-scroll="true" class="dropdown-item"
                href="{{ route('groups.files.archive', [$file->group, $file]) }}">
                <i class="fa fa-archive"></i>
                @if($file->isArchived())
                {{trans('messages.unarchive')}}
                @else
                {{trans('messages.archive')}}
                @endif
            </a>
            @endcan

        </div>
    </div>
    @endcan


</div>