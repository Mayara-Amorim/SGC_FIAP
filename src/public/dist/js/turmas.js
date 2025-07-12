window.turmasTable = null;
$(document).ready(() => {
  window.turmasTable = $("#turmas-table").DataTable({
    lengthMenu: [
      [25, 50, 100, -1],
      [25, 50, 100, "Todos"],
    ],
    ajax: {
      url: `/turmas/getAllTurmas`,
    },
    pagingType: "simple_numbers",
    responsive: true,
    processing: true,
    autoWidth: true,
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
          return `<div style="cursor:pointer" onclick="showEstudantes(${
            data.id
          })">${data.nome.toUpperCase()}</div>`;
        },
      },
      {
        data: "tipo",
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
              <li><a class="dropdown-item  p-2" title="Editar" onclick="editarTurma('${data.id}')">
                  Editar
              </a></li>
            </ul>
          </div>`;
          html += `
          <button class="btn btn-link text-danger me-2 p-0" title="Excluir" onclick="deletarTurma('${data.id}')">
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

  $("#turmas-table").on({
    "search.dt": (e) => {
      $('#turmas-table_wrapper input[type="search"]')
        .attr("disabled", "disabled")
        .off("keyup")
        .off("keydown")
        .off("keypress")
        .off("input");
    },
    "draw.dt": (e) => {
      $('[data-toggle="tooltip"]').tooltip();
      $('#turmas-table_wrapper input[type="search"]')
        .removeAttr("disabled")
        .on("keypress", (e) => {
          if (e.key === "Enter") {
            $('#turmas-table_wrapper input[type="search"]').attr(
              "disabled",
              "disabled"
            );
            $("#turmas-table").DataTable().search(e.target.value).draw();
          }
        });
    },
  });

  $("#createTurma_btn").off("click");
  $("#createTurma_btn").on("click", () => {
    createTurma();
  });
});
function createTurma() {
  const data = {
    descricao: $("#modal__descricao-turma").val().trim(),
    nome: $("#modal__nome-turma").val().trim(),
    tipo: $("#modal__tipo-turma").val().trim(),
  };
  if (data.descricao == "" || data.nome == "" || data.tipo == "-1") {
    return notifyError("Preencha todos os campos!");
  }

  if (data.nome.length < 8) {
    return notifyError("O nome deve ter pelo menos 8 caracteres!");
  }

  //showLoadingModal();
  $.post("/turmas/createTurma", data)
    .then((res) => {
      console.log(res);
      if (!res.error) {
        $("#modalTurma").modal("hide");
        turmasTable.ajax.reload();
        notifySuccess("Turma criada com sucesso!");
      }
    })
    .catch((ex) => {
      console.log(ex);
      return notifyError(ex);
    })
    .always(() => {
      //hideLoadingModal();
    });
}
$("#modalEstudante").on("show.bs.modal", () => {});

$("#modalEstudante").on("hide.bs.modal", () => {
  $("#createTurma_btn").off("click");
  $("#createTurma_btn").on("click", () => {
    createTurma();
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

function showEstudantes(idTurma) {
  $("#turma__estudantes tbody").empty();
  $.get(`/matriculas/getByEstudantesInTurma/${idTurma}`).then((res) => {
    console.log(res);
    res.forEach((item) => {
      $("#turma__estudantes tbody").append(`
        <tr>
          <td class="text-center">${item.NOME}</td>
          <td class="text-center">${moment(item.DATA_MATRICULA).format(
            "DD/MM/YYYY HH:mm"
          )}</td>
          </tr>
        `);
    });
  });
  $("#modalMatriculasTurma").modal("show");
}

function editarTurma(id) {
  //showLoadingModal();
  $.get(`/turmas/getByIdTurma/${id}`)
    .then((res) => {
      console.log(res);

      $("#modal__descricao-turma").val(res.descricao);
      $("#modal__nome-turma").val(res.nome);
      $("#modal__tipo-turma").val(res.tipo);

      $("#createTurma_btn").off("click");
      $("#createTurma_btn").on("click", () => {
        updateTurma(id);
      });
      $("#modalTurmaLabel").html("Editar Informações");
      $("#modalTurma").modal("show");
    })
    .catch((err) => {
      console.error(err);
      notifyError(err.responseJson.error);
    })
    .always(() => {
      //hideLoadingModal();
    });
}
function updateTurma(id) {
  const descricao = $("#modal__descricao-turma").val().trim();
  const nome = $("#modal__nome-turma").val().trim();
  const tipo = $("#modal__tipo-turma").val().trim();

  if (descricao == "" || nome == "" || tipo == "-1") {
    return notifyError("Preencha todos os campos!");
  }
  if (nome.length < 8) {
    return notifyError("O nome deve ter pelo menos 8 caracteres!");
  }

  const data = {
    nome,
    descricao,
    tipo,
  };
  //showLoadingModal();
  $.post(`/turmas/editTurma/${id}`, data)
    .then((res) => {
      $("#modalTurma").modal("hide");

      turmasTable.ajax.reload();

      notifySuccess("Turma editada com sucesso!");
    })
    .catch((err) => {
      console.log(err);
      notifyError(err.responseJson.error);
    })
    .always(() => {
      ////hideLoadingModal();
    });
}
function deletarTurma(id) {
  //showLoadingModal();
  $.post(`/turmas/delete/${id}`)
    .then((res) => {
      turmasTable.ajax.reload();
      notifySuccess("Turma excluída com sucesso!");
    })
    .catch((err) => {
      console.error(err);
      notifyError(err.responseJson.error);
    })
    .always(() => {
      ////hideLoadingModal();
    });
}
