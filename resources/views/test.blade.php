@extends('layouts.app')

@section('content')
<script>
    $(document).ready(function(){
        $("button").click(function(){
            $("ol").append("<li>list item <a href='javascript:void(0);' class='remove'>&times;</a></li>");
        });
        $(document).on("click", "a.remove" , function() {
            $(this).parent().remove();
        });
    });
</script>

    <button>Add new list item</button>
    <p>Click the above button to dynamically add new list items. You can remove it later.</p>
    <ol>
        <li>list item</li>
        <li>list item</li>
        <li>list item</li>
    </ol>
@endsection
