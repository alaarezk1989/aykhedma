@if(count($node->children) == 0)
    <li style="{{ $parents ? "" : "display:none;" }}">
        <span>
            <i class="fa fa-map-marker" ></i> {{ $node->name }}
                <a data-toggle="modal" data-target="#delete_model_{{ $node->id }}"><i class="fa fa-trash"></i></a>   

                <a href="{{route('admin.locations.edit',['location' => $node])}}"><i class="fa fa-edit"></i></a>
      </span>
        
    </li>

@else
    <li class="parent_li">
        <span title="Expand this branch"><i class="fa fa-plus"></i> {{ $node->name }}</span>
        <i class="fa fa-delete"> 
            <a data-toggle="modal" data-target="#delete_model_{{ $node->id }}"><i class="fa fa-trash"></i></a>   
            
            <a href="{{route('admin.locations.edit',['location' => $node])}}" ><i class="fa fa-edit"></i></a>
            
        </i>
        <ul>
            @foreach($node->children as $child)
                @include('admin.locations.node', ['node' => $child, 'parents' => false])
            @endforeach
        </ul>
    </li>
@endif

