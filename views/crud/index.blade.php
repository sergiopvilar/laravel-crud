@extends('layouts.default')

@section('content')

    <h2>
        {{  $name }}
        <a href="/admin/{{ $route }}/create" class="btn btn-primary pull-right">Cadastrar novo</a>
    </h2>

    <table class="table">

        <thead>
            @foreach($grid as $item)
            <th>{{ $grid_name[$item][0] }}</th>
            @endforeach
            <th style="width:180px">Ações</th>
        </thead>

        <tbody>
    @foreach($data as $item)
        <tr>
        @foreach($fields as $field => $value)
            @if(in_array($field, $grid))
                <td>{{ $item->{$field} }}</td>
            @endif
        @endforeach
            <td>
                <a class="btn btn-info" href="/admin/{{$route}}/{{$item->id}}/edit">Editar</a>
                <a class="btn btn-danger" href="javascript:checkDelete({{$item->id}});">Apagar</a>
            </td>
        </tr>
    @endforeach
        </tbody>

    </table>

    <script>
        function checkDelete(id) {
            if (confirm('Deseja realmente apagar?')) {
                $.ajax({
                    type: "DELETE",
                    url: '/admin/{{$route}}/' + id,
                    data: {
                        '_token': "{{csrf_token()}}"
                    },
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        }
    </script>

@stop
