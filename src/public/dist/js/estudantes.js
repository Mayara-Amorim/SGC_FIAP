window.estudantesTable = null;
$(document).ready(() => {
  window.estudantesTable = $("#estudantes-table").DataTable({
    lengthMenu: [
      [25, 50, 100, -1],
      [25, 50, 100, "Todos"],
    ],
    ajax: {
      url: `/estudantes/getAllEstudantes`,
    },
    pagingType: "simple_numbers",
    responsive: true,
    processing: true,
    autoWidth: true,
    serverSide: true,
    serverSide: true,
    language: {
      url: "/src/public/dist/lang/pt_br.json",
    },
    order: [[0, "asc"]],
    columns: [
      {
        data: null,
        name: "nome",
        sortable: true,
        render: (data) => {
          return data.nome.toUpperCase();
        },
      },
      {
        data: null,
        render: (data) => {
          return moment(data.data_nascimento).format("DD-MM-YYYY");
        },
      },
      {
        data: null,
        render: (data) => {
          return data.email;
        },
      },
      {
        data: null,
        render: (data) => {
          let html = "";
          let dropdown = `
          <div class="dropdown-center">
            <div class="dropdown-toggle title" type="button" data-bs-toggle="dropdown" aria-expanded="false">
             <i class="bi bi-list-task"></i>
            </div>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item  p-2" title="Editar" onclick="editarEstudante('${data.id}')">
                  Editar
              </a></li>   
              <li><a class="dropdown-item p-2" title="Matricular" onclick="matricularEstudante('${data.id}', '${data.nome}')">
                    Matricular
              </a></li>
            </ul>
          </div>`;
          html += `
          <button class="btn btn-link text-danger me-2 p-0" title="Excluir" onclick="deletarEstudante('${data.id}')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
              </svg>
          </button>`;
          return `<div class="d-flex justify-content-center">${html}${dropdown}</div>`;
        },
      },
    ],
  });

  $("#estudantes-table").on({
    "search.dt": (e) => {
      $('#estudantes-table_wrapper input[type="search"]')
        .attr("disabled", "disabled")
        .off("keyup")
        .off("keydown")
        .off("keypress")
        .off("input");
    },
    "draw.dt": (e) => {
      $('[data-toggle="tooltip"]').tooltip();
      $('#estudantes-table_wrapper input[type="search"]')
        .removeAttr("disabled")
        .on("keypress", (e) => {
          if (e.key === "Enter") {
            $('#estudantes-table_wrapper input[type="search"]').attr(
              "disabled",
              "disabled"
            );
            $("#estudantes-table").DataTable().search(e.target.value).draw();
          }
        });
    },
  });

  $("#createEstudante_btn").off("click");
  $("#createEstudante_btn").on("click", () => {
    createEstudante();
  });
});
function createEstudante() {
  const data = {
    dt_nasc: $("#modal__data_nascimento-estudante").val(),
    nome: $("#modal__nome-estudante").val(),
    email: $("#modal__email-estudante").val(),
  };
  if (data.dt_nasc == "" || data.nome == "" || data.email == "") {
    return notifyError("Preencha todos os campos!");
  }

  if (data.nome.length < 8) {
    return notifyError("O nome deve ter pelo menos 8 caracteres!");
  }
  //showLoadingModal();
  $.post("/estudantes/createEstudante", data)
    .then((res) => {
      console.log(res);
      if (!res.error) {
        $("#modalEstudante").modal("hide");
        estudantesTable.ajax.reload();
        notifySuccess("Estudante criado com sucesso!");
      }
    })
    .catch((ex) => {
      console.log(ex);
      return notifyError("Falha na autenticação");
    })
    .always(() => {
      //hideLoadingModal();
    });
}
$("#modalEstudante").on("show.bs.modal", () => {});

$("#modalEstudante").on("hide.bs.modal", () => {
  $("#createEstudante_btn").off("click");
  $("#createEstudante_btn").on("click", () => {
    createEstudante();
  });
  $("#modalEstudanteLabel").html("Cadastrar Estudante");
  $("#modal__data_nascimento-estudante").val("");
  $("#modal__nome-estudante").val("");
  $("#modal__email-estudante").val("");
  $("#modal__data_nascimento-estudante").attr(
    "max",
    moment().subtract(1, "days").format("YYYY-MM-DD")
  );
});

function editarEstudante(id) {
  //showLoadingModal();
  $.get(`/estudantes/getByIdEstudante/${id}`)
    .then((res) => {
      console.log(res);
      $("#modal__email-estudante").val(res.email);
      $("#modal__nome-estudante").val(res.nome);
      $("#modal__data_nascimento-estudante").val(res.data_nascimento);

      $("#createEstudante_btn").off("click");
      $("#createEstudante_btn").on("click", () => {
        update(id);
      });
      $("#modalEstudanteLabel").html("Editar Informações");
      $("#modalEstudante").modal("show");
    })
    .catch((err) => {
      console.error(err);
    })
    .always(() => {
      //hideLoadingModal();
    });
}

$("#modalMatricula").on("hide.bs.modal", () => {
  $("#modal__matricula-estudante").val("");
  $("#modal__matricula-turma").val("-1");
});

function matricularEstudante(id, nome) {
  $("#modal__matricula-estudante").val(nome);

  $("#createMatricula_btn").off("click");
  $("#createMatricula_btn").on("click", () => {
    const turma = $("#modal__matricula-turma").val();
    if (turma == "-1") {
      notifyError("Selecione uma turma");
      return;
    }
    showLoadingModal();
    $.post("/matriculas/createMatricula", {
      turma,
      estudante: id,
    })
      .then((res) => {
        if (!res.error) {
          estudantesTable.ajax.reload();
          notifySuccess("Estudante matriculado com sucesso!");
          $("#modalMatricula").modal("hide");
        }
      })
      .catch((er) => {
        notifyError("Não foi possivel matricular o aluno");
        console.error(er);
      })
      .always(() => hideLoadingModal());
  });

  $("#modalMatricula").modal("show");
}

function update(id) {
  const email = $("#modal__email-estudante").val();
  const nome = $("#modal__nome-estudante").val().trim();
  const dt_nasc = $("#modal__data_nascimento-estudante").val();
  if (email == "" || nome == "" || dt_nasc == "") {
    return notifyError("Preencha todos os campos!");
  }
  if (moment(dt_nasc).isAfter(moment())) {
    notifyError("informe uma data valida");
    return;
  }
  const data = {
    nome,
    dt_nasc,
    email,
  };
  //showLoadingModal();
  $.post(`/estudantes/editEstudante/${id}`, data)
    .then((res) => {
      $("#modalEstudante").modal("hide");

      estudantesTable.ajax.reload();

      notifySuccess("Estudante editado com sucesso!");
    })
    .catch((err) => {
      console.log(err);
    })
    .always(() => {
      ////hideLoadingModal();
    });
}
function deletarEstudante(id) {
  //showLoadingModal();
  $.post(`/estudantes/delete/${id}`)
    .then((res) => {
      estudantesTable.ajax.reload();
      notifySuccess("Estudante excluído com sucesso!");
    })
    .catch((err) => {
      console.error(err);
    })
    .always(() => {
      ////hideLoadingModal();
    });
}
