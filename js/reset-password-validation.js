document.addEventListener("DOMContentLoaded", function () {
  const validation = new JustValidate("#reset-password", {
    errorLabelStyle: {
      color: "rgb(190 18 60)", // Tailwind's red-400 equivalent (or use any color code)
      fontSize: "0.875rem", // Equivalent to Tailwind's `text-sm`
      marginTop: "0.25rem", // Equivalent to `mt-1`
    },
  });

  validation

    .addField("#password", [
      {
        rule: "required",
        errorMessage: "Password is required",
      },
      {
        validator: (value) => {
          // Ensure password is at least 8 characters long, contains at least one letter, and at least one number
          return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value);
        },
        errorMessage:
          "Password must be at least 8 characters long, contain at least one letter and one number",
      },
      {
        rule: "minLength",
        value: 6,
        errorMessage: "Password must be at least 6 characters long",
      },
    ])
    .addField("#password_confirmation", [
      {
        rule: "required",
      },
      {
        validator: (value, fields) => {
          return value === fields["#password"].elem.value;
        },
        errorMessage: "Passwords should match",
      },
    ])

    .onSuccess((event) => {
      document.getElementById("reset-password").submit();
    });
});
