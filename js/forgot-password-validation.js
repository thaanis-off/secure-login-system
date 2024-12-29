document.addEventListener("DOMContentLoaded", function () {
  const validation = new JustValidate("#forgot-password", {
    errorLabelStyle: {
      color: "rgb(190 18 60)", // Tailwind's red-400 equivalent (or use any color code)
      fontSize: "0.875rem", // Equivalent to Tailwind's `text-sm`
      marginTop: "0.25rem", // Equivalent to `mt-1`
    },
  });

  validation
    .addField("#email", [
      {
        rule: "required",
        errorMessage: "Email is required",
      },
      {
        rule: "email",
        errorMessage: "Email is not valid",
      },
    ])

    .onSuccess((event) => {
      document.getElementById("forgot-password").submit();
    });
});
