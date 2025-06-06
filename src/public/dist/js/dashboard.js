$("#estudantes-tab").on("click", () => {
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
    order: [[0, "asc"]],
    columns: [
      {
        data: null,
        name: "nome",
        sortable: true,
        render: (data) => {
          return data.nome;
        },
      },
      {
        data: null,
        render: (data) => {
          return moment(data.data_nascimento).format("DD-MM-YY");
        },
      },
      {
        data: null,
        render: (data) => {
          return data.email;
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
});

$("#turmas-tab").on("click", () => {
  window.turmasTable = $("#turmas-table").DataTable({
    lengthMenu: [
      [25, 50, 100, -1],
      [25, 50, 100, "Todos"],
    ],
    ajax: {
      url: `/turmas/getAllturmas`,
    },
    pagingType: "simple_numbers",
    responsive: true,
    processing: true,
    autoWidth: true,
    serverSide: true,
    order: [[0, "asc"]],
    columns: [
      {
        data: null,
        name: "nome",
        sortable: true,
        render: (data) => {
          return data.nome;
        },
      },
      {
        data: null,
        render: (data) => {
          return moment(data.data_nascimento).format("DD-MM-YY");
        },
      },
      {
        data: null,
        render: (data) => {
          return data.email;
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
});

$("#matriculas-tab").on("click", () => {
  window.matriculasTable = $("#matriculas-table").DataTable({
    lengthMenu: [
      [25, 50, 100, -1],
      [25, 50, 100, "Todos"],
    ],
    ajax: {
      url: `/matriculas/getAllmatriculas`,
    },
    pagingType: "simple_numbers",
    responsive: true,
    processing: true,
    autoWidth: true,
    serverSide: true,
    order: [[0, "asc"]],
    columns: [
      {
        data: null,
        name: "nome",
        sortable: true,
        render: (data) => {
          return data.nome;
        },
      },
      {
        data: null,
        render: (data) => {
          return moment(data.data_nascimento).format("DD-MM-YY");
        },
      },
      {
        data: null,
        render: (data) => {
          return data.email;
        },
      },
    ],
  });

  $("#matriculas-table").on({
    "search.dt": (e) => {
      $('#matriculas-table_wrapper input[type="search"]')
        .attr("disabled", "disabled")
        .off("keyup")
        .off("keydown")
        .off("keypress")
        .off("input");
    },
    "draw.dt": (e) => {
      $('[data-toggle="tooltip"]').tooltip();
      $('#matriculas-table_wrapper input[type="search"]')
        .removeAttr("disabled")
        .on("keypress", (e) => {
          if (e.key === "Enter") {
            $('#matriculas-table_wrapper input[type="search"]').attr(
              "disabled",
              "disabled"
            );
            $("#matriculas-table").DataTable().search(e.target.value).draw();
          }
        });
    },
  });
});

$("#createEstudante_btn").on("click", () => {
  const data = {
    dt_nasc: $("#modal__data_nascimento-estudante").val(),
    nome: $("#modal__nome-estudante").val(),
    email: $("#modal__email-estudante").val(),
  };
  if (data.dt_nasc == "" || data.nome == "" || email == "") {
    return notifyError("Preencha todos os campos!");
  }

  $.post("/estudantes/createEstudante", data)
    .then((res) => {
      console.log(res);
      if (!res.error) {
        estudantesTable.ajax.reload();
        notifySuccess("Estudante criado com sucesso!");
      }
    })
    .catch((ex) => {
      console.log(ex);
      return notifyError("Falha na autenticação");
    });
});
$("#modalEstudante").on("show.bs.modal", () => {
  $("#modal__data_nascimento-estudante").val("");
  $("#modal__nome-estudante").val("");
  $("#modal__email-estudante").val("");
  $("#modal__data_nascimento-estudante").attr("min", moment().sub(1, "days"));
});
