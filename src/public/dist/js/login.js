$("#login__acessar").on("click", () => {
  const data = {
    email: $("#login__email").val(),
    senha: $("#login__senha").val(),
  };

  $.post("/usuarios/login", data)
    .then((res) => {
      console.log(res);
      if (!res.error) {
        window.location.href = "/dashboard";
        return;
      }
    })
    .catch((ex) => {
      console.log(ex);
      notifyError("Falha na autenticação");
    });
});
