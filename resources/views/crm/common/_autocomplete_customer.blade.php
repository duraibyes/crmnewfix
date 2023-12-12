<div>
    <ul>
        @if(isset($list) && count( $list )> 0)
        
            @foreach ($list as $item)
                <li onclick="return cus_auto_operand('{{ $item->id }}', '{{ $item->type }}')">
                    {{ $item->first_name .' ' .$item->email}} 
                </li>
            @endforeach
        @else
            <li > {{ $query }} &emsp; no found </li>
        @endif
       
    </ul>
</div>