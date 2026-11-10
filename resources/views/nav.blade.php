<div class="bg-black text-white" mb-5>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col p3">
                <h3 class="text-primary">Gestor de Tarefas</h3>
            </div>
            <div class="col p3 text-end">
                

                <span><i class="bi bi-person-circle me-2"></i>{{ session()->get('username')}}</span>
                <span class="mx-3 opacity-50"><i class="bi bi-three-dots-vertical"></i></span>
                <a href="{{route('logout')}}" class="btn btn-outline-danger"><i class="bi bi-box-arrow-in-right me-2"></i>Sair</a>
            </div>
        </div>
    </div>

</div>
