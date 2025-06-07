window.matriculassTable = null;

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
          return data.nome.toUpperCase();
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
