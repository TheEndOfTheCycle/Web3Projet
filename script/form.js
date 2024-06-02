document.addEventListener("DOMContentLoaded", function () {
  let form = document.querySelector("#log-form");
  let email = document.querySelector("#email");
  let password = document.querySelector("#password");
  let ajaxResponse = document.querySelector("#ajax-response");

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    if (checkForm()) {
      sendRequest();
    }
  });

  function checkForm() {
    let ok = true;

    let emailValue = email.value.trim();
    let passwordValue = password.value.trim();

    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    let errorLogo = `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>`;

    if (emailValue === "") {
      let input = email.parentElement;
      let errorDisplay = input.querySelector(".error");

      errorDisplay.innerHTML =
        errorLogo + "&nbsp; Veuillez entrer une adresse e-mail valide.";
      input.classList.add("error");
      input.classList.remove("success");

      ok = false;
    } else if (!emailPattern.test(emailValue)) {
      let input = email.parentElement;
      let errorDisplay = input.querySelector(".error");

      errorDisplay.innerHTML =
        errorLogo +
        " &nbsp; Veuillez entrer une adresse e-mail valide au format exemple@domaine.com.";
      input.classList.add("error");
      input.classList.remove("success");

      ok = false;
    } else {
      let input = email.parentElement;
      let errorDisplay = input.querySelector(".error");

      errorDisplay.innerText = "";
      input.classList.add("success");
      input.classList.remove("error");
    }

    if (passwordValue === "" || passwordValue.length < 6) {
      let input = password.parentElement;
      let errorDisplay = input.querySelector(".error");

      errorDisplay.innerHTML =
        errorLogo +
        "&nbsp; Votre mot de passe doit comporter entre 6 et 60 caractères.";
      input.classList.add("error");
      input.classList.remove("success");

      ok = false;
    } else {
      let input = password.parentElement;
      let errorDisplay = input.querySelector(".error");

      errorDisplay.innerText = "";
      input.classList.add("success");
      input.classList.remove("error");
    }

    return ok;
  }

  function sendRequest() {
    const url = form.action;
    const formData = new FormData(form);

    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
      if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
          let result = JSON.parse(httpRequest.responseText);

          if (result.status === "success") {
            ajaxResponse.innerHTML =
              '<div class="success">' + result.message + "</div>";
            form.reset();
            document
              .querySelectorAll(".input")
              .forEach((input) => input.classList.remove("success", "error"));

            // Redirection en cas de succès
            window.location.href = result.redirect;
          } else {
            ajaxResponse.innerHTML =
              '<div class="error">' + result.message + "</div>";
          }
        } else {
          ajaxResponse.innerHTML =
            '<div class="error">An error occurred. Please try again later.</div>';
        }
      }
    };

    httpRequest.open("POST", url);
    httpRequest.send(formData);
  }
});
