<div class="row  ">
    <div class="col-md-6 mb-3">
       <h3 class="h4 link">
           <a href="#" class="me-1">{{ $info->lead_title ?? $info->lead_subject }}</a> 
           <i class="mdi mdi-tag"></i>

           <small> Created At : {{ date('M d,Y', strtotime($info->created_at)) }} </small>
        </h3>
        <div class="d-flex">
            @if( isset($info->lead_value ) && !empty($info->lead_value))
            <div class="btn ps-0"><b class="h4">RS.{{ $info->lead_value }}</b></div>
            @endif
            {{-- <div class="btn link">5 Products</div> --}}
            <div class="btn"><i class="me-1 dripicons-user"></i> {{ $info->customer->first_name ?? '' }} {{ $info->customer->email ?? '' }}</div>
            <div class="btn"><i class="me-1 mdi-office-building mdi"></i> {{ $info->customer->company->name ?? '' }}</div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="d-flex align-items-center justify-content-end">
            @if( isset( $info->status ) && $info->status != 2 && ( Auth::id() == $info->assigned_to || $info->assigned_to == null || superadmin() ) )
            @if(Auth::user()->hasAccess('leads', 'is_edit') || Auth::user()->hasAccess('leads', 'is_delete') || superadmin())
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if(Auth::user()->hasAccess('leads', 'is_edit'))
                        <a class="dropdown-item" href="#" onclick="return get_deal_modal('{{ $info->id }}')">Convert to Deal</a>
                    @endif
                    @if(Auth::user()->hasAccess('leads', 'is_delete'))
                        <a class="dropdown-item" href="#" onclick="return common_soft_delete('lead_delete', '{{ $info->id }}')">Delete Lead</a>
                    @endif
                </div>
            </div>
            @endif
            @else 
            <div>
                <button class="btn btn-success">Converted to Deal</button>
            </div>
            @endif
        </div>
    </div>
    {{-- <div class="col-md-12 mb-2"> 
        
        <div class="form-group">
           
            
        
        </div>
    </div> --}}
</div>