<ul>
    @foreach($childs as $child)
    <li>
                                    
        <span class="tf-nc" style="font-size:15px;">
            <a href="#">
                <i class="fas fa-atom" style="font-size:30px; color:red;"></i></a>
            <br>
            {{ $child->fullname }}
            <br>
            {{ $child->referral_code }}
            </span>
        @if(count($child->childs))
            @include('admin.company-tree.manageChild',['childs' => $child->childs])                                                
        @endif
    </li>
    @endforeach
</ul>