<ul class="double">
@foreach($childs as $key=>$child)
@if($loop->depth <= 6)
    @if(!empty($child->id))
   
    <li class="col">
    <span class="tf-nc" style="font-size:15px;">
    <a href="">
        <!-- <i class="fas fa-atom" style="font-size:30px; color:#08ff41"></i></a> -->
        <i class="fas fa-atom" style="font-size:30px; color:red"></i></a>
    <br>
        {{ $child->fullname }}
        <br>
        {{ $child->referral_code }}
        </span>
        
        @if(count($child->childs))
            @include('distributor.treeview.manageChild',['childs' => $child->childs])
        @endif
    </li>
    @else
    <li style="visibility:hidden" class="col">
    <span class="tf-nc" style="font-size:15px;">
    <a href="">
        <!-- <i class="fas fa-atom" style="font-size:30px; color:#08ff41"></i></a> -->
        <i class="fas fa-atom" style="font-size:30px; color:red"></i></a>
        <br>
        MCP#########
        <br>
        </span>
        
    </li>
    @endif
@endif
@endforeach
</ul>