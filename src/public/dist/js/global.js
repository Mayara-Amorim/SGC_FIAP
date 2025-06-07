window.notifySuccess = ($msg) => {
  $.notify($msg, {
    className: "success",
    globalPosition: "top center",
  });
};
window.notifyError = ($msg) => {
  toastr.error($msg);
  toastr.options = {
    positionClass: "toast-top-center",
    closeButton: true,
    progressBar: true,
    timeOut: "3000",
  };
};
window.notifyWarning = ($msg) => {
  toastr.warning($msg);
  toastr.options = {
    positionClass: "toast-top-center",
    closeButton: true,
    progressBar: true,
    timeOut: "3000",
  };
};

window.showLoadingModal = () => {
  const modal = new bootstrap.Modal($("#loading-modal"));
  modal.show();
  window._loadingModal = modal;
};

window.hideLoadingModal = () => {
  if (window._loadingModal) {
    setTimeout(() => {
      window._loadingModal.hide();
    }, 600);
  }
};

// toastr.success("Login realizado com sucesso!");
// toastr.error("Erro ao tentar fazer login!");
// toastr.info("Preencha todos os campos obrigatórios.");
// toastr.warning("Atenção: sua sessão está prestes a expirar.");
