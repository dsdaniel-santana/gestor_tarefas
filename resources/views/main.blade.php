@extends('templates/main_layout')

@section('content')

<div class="container">
    <div class="row mt-5">
        <div class="col">

            <div class="row align-items-center mb-3">
                <div class="col">
                        <h4>Tarefas</h4>
                </div>
                
                <div class="col-6 text-center">
                    <form action="{{route('search_submit')}}" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="text_search" id="text_search" class="form-control" placeholder="Pesquisar">
                            <button class="btn btn-outline-primary ms-3" ><i class="bi bi-search"></i></button>

                            <span class="mx-3"></span>

                            <label class="me-2 align-self-center">Status</label>
                            <select name="filter" id="filter">
                                <option value="all">Todos</option>
                                <option value="new">Nova</option>
                                <option value="in_progress">Em Progresso</option>
                                <option value="cancelled">Cancelada</option>
                                <option value="completed">Concluída</option>

                            </select>

                        </div>
                    </form>
                </div>

                <div class="col text-end">
                    <a href="{{ route('new_task') }}" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i> Nova Tarefa </a>
                </div>
                
            </div>
            

            @if(count($tasks) != 0)

                <table class="table table-striped table-bordered" id="table_tasks" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="w-75">Tarefa</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody> </tbody>

                </table>
            @else
                <p class="text-center opacity-50 my-5">Não existem tarefas registradas </p>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#table_tasks').DataTable({
            data: @json($tasks),
            columns:[
                {data: 'task_name'},
                {data: 'task_status', className:'text-center'},
                {data: 'task_actions', className:'text-center'},
            ]    
        });
    });

   
</script>

@endsection
