<?php
require_once __DIR__ . "/../Constants/Tipo.php";
require_once __DIR__ . "/../Model/TurmaModel.php";

$turmas = (new TurmaModel())->getByAtivoTurmas();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Gerenciamento</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> <!-- Datatable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <!-- CSS SGC_FIAP -->
  <link rel="stylesheet" href="/src/public/dist/css/dashboard.css">
</head>

<body>
  <div class="welcome" style="background-color:var(--color-primary); color: var(--color-white); display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; font-family: Arial, sans-serif;">
    <div style="display: flex; align-items: center;">
      <div style="border-left: 1px solid white; padding-left: 15px;">
        <div style="font-weight: bold; font-size: 18px;">Educação</div>
        <div style="font-size: 14px;">Ambiente do ADMIN</div>
      </div>
    </div>
    <div style="display: flex; align-items: center;">
      <div style="display: flex; align-items: center;">
        <div style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
          <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg></span>
        </div>
        <div>
          <div style="font-weight: bold;"><?= $_SESSION['usuario_nome'] ?> </div>
          <div style="font-size: 12px;"><?= $_SESSION['usuario_email'] ?></div>
        </div>
        <div class="btn-group">
          <button id="dash__cared-down" type="button" class="btn text-white border-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          </button>
          <ul class="dropdown-menu">
            </li>
            <li> <a class="dropdown-item d-flex align-items-center gap-2" href="/usuarios/logout">
                Logout
                <i class="bi bi-box-arrow-right title"></i>
              </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">


    <div class="row d-flex justify-content-end">
    </div>
    <ul class="nav nav-underline mb-3 justify-content-around" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active " id="estudantes-tab" data-bs-toggle="tab" data-bs-target="#estudantes" type="button" role="tab">Estudantes</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="turmas-tab" data-bs-toggle="tab" data-bs-target="#turmas" type="button" role="tab">Turmas</button>
      </li>

    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="estudantes" role="tabpanel">
        <h3 class="title">Estudantes</h3>
        <div>
          <p>Aqui você pode gerenciar os estudantes cadastrados no sistema.</p>
          <button type="button" class="btn btn-outline primary-color" data-bs-toggle="modal" data-bs-target="#modalEstudante">Cadastrar</button>
        </div>


        <div class="container-table mt-4" id="table-estudantes">
          <table class="table w-100" style="text-align: center; overflow-x: auto;" id="estudantes-table" aria-live="polite">
            <thead>
              <tr>
                <th scope="col" style="width: 40% !important; background-color:var(--color-primary);color:var(--color-white)" class="text-center">Nome</th>
                <th scope="col" style="white-space: nowrap; background-color:var(--color-primary);color:var(--color-white)" class="text-center">Nascimento</th>
                <th scope="col" style="white-space: nowrap; background-color:var(--color-primary);color:var(--color-white)" class="text-center">Email</th>
                <th scope="col" style="white-space: nowrap; background-color:var(--color-primary);color:var(--color-white)" class="text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
      <div class="tab-pane fade" id="turmas" role="tabpanel">
        <h3 class="title">Turmas</h3>
        <p>Aqui você pode gerenciar as turmas e seus respectivos dados.</p>
        <button type="button" class="btn btn-outline primary-color" data-bs-toggle="modal" data-bs-target="#modalTurma">
          Cadastrar Turma
        </button>

        <div class="container-table mt-4" id="table-turmas">
          <table class="table w-100" style="text-align: center; overflow-x: auto;" id="turmas-table" aria-live="polite">
            <thead>
              <tr>
                <th scope="col" style="width: 40% !important;background-color:var(--color-primary);color:var(--color-white)" class="text-center">Nome</th>
                <th scope="col" style="white-space: nowrap;background-color:var(--color-primary);color:var(--color-white)" class="text-center">Tipo</th>
                <th scope="col" style="white-space: nowrap;background-color:var(--color-primary);color:var(--color-white)" class="text-center">Ações</th>

              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>



      </div>
      <div class="tab-pane fade" id="matriculas" role="tabpanel">
        <h3>Matrículas</h3>
        <p>Aqui você pode visualizar e gerenciar as matrículas dos estudantes.</p>

        <div class="container-table mt-4" id="table-matriculas">
          <table class="table w-100" style="text-align: center; overflow-x: auto;" id="matriculas-table" aria-live="polite">
            <thead>
              <tr>
                <th scope="col" style="width: 40% !important;">Estudante</th>
                <th scope="col" style="white-space: nowrap;">Data</th>
                <th scope="col" style="white-space: nowrap;">Turma</th>
                <th scope="col" style="white-space: nowrap;">Ações</th>

              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Estudante -->
  <div class="modal fade" id="modalEstudante" tabindex="-1" aria-labelledby="modalEstudanteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header">
          <h5 class="modal-title title" id="modalEstudanteLabel">Cadastrar Estudante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div id="formEstudante">
            <div class="mb-3">
              <label for="nome" class="form-label required">Nome</label>
              <input type="text" class="form-control" id="modal__nome-estudante" name="nome" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label required">E-mail</label>
              <input type="email" class="form-control" id="modal__email-estudante" name="email" required>
            </div>
            <div class="mb-3">
              <label for="data_nascimento" class="form-label required">Data de Nascimento</label>
              <input type="date" class="form-control" id="modal__data_nascimento-estudante" name="data_nascimento" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
          <button id="createEstudante_btn" class="btn btn-dark">Salvar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Estudante -->


  <!-- Modal Turma -->
  <div class="modal fade" id="modalTurma" tabindex="-1" aria-labelledby="modalTurmaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header">
          <h5 class="modal-title title" id="modalTurmaLabel">Cadastrar Turma</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div id="formTurma">
            <div class="mb-3">
              <label for="nome" class="form-label required">Nome</label>
              <input type="text" class="form-control" id="modal__nome-turma" name="nome" required>
            </div>
            <div class="mb-3">
              <label class="form-label required">Tipo</label>
              <select id="modal__tipo-turma" class="form-control">
                <option value="-1" selected disabled>Selecione</option>
                <? foreach (TIPO as $tipo): ?>
                  <option value="<?= $tipo ?>"><?= $tipo ?></option>
                <? endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label required">Descrição</label>
              <textarea id="modal__descricao-turma" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
          <button id="createTurma_btn" class="btn btn-dark">Salvar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Turma -->

  <!-- Loading -->
  <div class="modal fade" id="loading-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog d-flex justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="spinner-border text-dark" style="width: 5rem; height: 5rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>


  <!-- Loading -->
  <!-- Modal Matricula -->
  <div class="modal fade" id="modalMatricula" tabindex="-1" aria-labelledby="modalMatriculaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header">
          <h5 class="modal-title primary-color" id="modalMatriculaLabel">Matricular estudante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div id="formMatricula">
            <div class="mb-3">
              <label for="nome" class="form-label required">Nome</label>
              <input type="text" class="form-control" value="" id="modal__matricula-estudante" disabled>
            </div>
            <div class="mb-3">
              <label for="nome" class="form-label required">Turma</label>
              <select id="modal__matricula-turma" class="form-control">
                <option value="-1" selected disabled>Selecione</option>
                <? foreach ($turmas as $turma): ?>
                  <option value="<?= $turma["id"] ?>"><?= $turma["nome"] ?></option>
                <? endforeach ?>

              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
          <button id="createMatricula_btn" class="btn btn-dark">Matricular</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal matricula -->
  <div class="modal fade" id="modalMatriculasTurma" tabindex="-1" role="dialog" aria-labelledby="modalComunicadoDetails" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="title m-0">Detalhes da Turma</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

        </div>
        <div class="modal-body ">
          <table class="table" id="turma__estudantes" tabindex="0">
            <thead>
              <th scope="col" style="text-align: center; white-space:nowrap;">Nome</th>
              <th scope="col" style="text-align: center; white-space:nowrap;">Data de matricula</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notifyjs-browser@0.4.2/dist/notify.min.js"></script>
  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Datatable JS -->
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <!-- JavaScript -->
  <script src="/src/public/dist/js/global.js"></script>
  <script src="/src/public/dist/js/estudantes.js"></script>
  <script src="/src/public/dist/js/turmas.js"></script>
  <script src="/src/public/dist/js/matriculas.js"></script>
</body>

</html>